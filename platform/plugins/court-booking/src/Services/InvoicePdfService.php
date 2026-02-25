<?php

namespace Botble\CourtBooking\Services;

use Botble\CourtBooking\Models\BookingList;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class InvoicePdfService
{
    /**
     * Generate PDF invoice for a booking
     */
    public function generatePdf(BookingList $booking): \Barryvdh\DomPDF\PDF
    {
        $booking->load('bookingServices.service');

        $data = [
            'booking' => $booking,
            'invoice_number' => $this->generateInvoiceNumber($booking),
            'generated_at' => Carbon::now(),
            'company' => [
                'name' => setting('admin_title', 'Sân Cầu Lông Niên Thời'),
                'address' => setting('company_address', '123 Đường ABC, Quận 1, TP.HCM'),
                'phone' => setting('company_phone', '0901234567'),
                'email' => setting('email_from_address', 'info@sancaulong.vn'),
            ],
        ];

        $pdf = Pdf::loadView('plugins/court-booking::invoice-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }

    /**
     * Stream PDF to browser (for preview/print)
     */
    public function streamPdf(BookingList $booking)
    {
        $pdf = $this->generatePdf($booking);
        $filename = 'hoa-don-' . ($booking->order_code ?? $booking->id) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Download PDF
     */
    public function downloadPdf(BookingList $booking)
    {
        $pdf = $this->generatePdf($booking);
        $filename = 'hoa-don-' . ($booking->order_code ?? $booking->id) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Save PDF to storage and return path
     */
    public function savePdf(BookingList $booking): string
    {
        $pdf = $this->generatePdf($booking);
        $filename = 'invoices/hoa-don-' . ($booking->order_code ?? $booking->id) . '-' . time() . '.pdf';

        \Storage::put('public/' . $filename, $pdf->output());

        return 'storage/' . $filename;
    }

    /**
     * Send invoice via email
     */
    public function sendEmail(BookingList $booking, ?string $email = null): bool
    {
        $email = $email ?: $booking->email;
        if (!$email) {
             // Fallback to contact if it looks like email
             if (filter_var($booking->contact, FILTER_VALIDATE_EMAIL)) {
                 $email = $booking->contact;
             }
        }

        if (!$email) return false;

        try {
            $pdf = $this->generatePdf($booking);
            $filename = 'hoa-don-' . ($booking->order_code ?? $booking->id) . '.pdf';

            Mail::send('plugins/court-booking::emails.invoice', [
                'booking' => $booking,
                'company_name' => setting('admin_title', 'Sân Cầu Lông'),
            ], function ($message) use ($email, $booking, $pdf, $filename) {
                $message->to($email)
                    ->subject('Hóa đơn đặt sân - ' . ($booking->order_code ?? '#' . $booking->id))
                    ->attachData($pdf->output(), $filename, [
                        'mime' => 'application/pdf',
                    ]);
            });

            // Mark invoice as sent
            $booking->update([
                'invoice_created_at' => Carbon::now(),
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate invoice number
     */
    private function generateInvoiceNumber(BookingList $booking): string
    {
        $date = Carbon::parse($booking->date)->format('Ymd');
        return 'INV-' . $date . '-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Auto-generate invoice when booking is marked as paid/completed
     */
    public static function autoGenerateOnPayment(BookingList $booking): void
    {
        // Only for paid/completed bookings
        if (!in_array($booking->status, ['paid', 'completed'])) {
            return;
        }

        // Check if invoice already created
        if ($booking->invoice_created_at) {
            return;
        }

        $service = new self();

        // Save PDF
        $pdfPath = $service->savePdf($booking);

        // Update booking with invoice info
        $booking->update([
            'invoice_created_at' => Carbon::now(),
            'notes' => ($booking->notes ?? '') . "\n[Hóa đơn: " . $pdfPath . "]",
        ]);

        // Send email
        $service->sendEmail($booking);
    }

    /**
     * Generate Grouped PDF invoice
     */
    public function generateGroupedPdf($bookings): \Barryvdh\DomPDF\PDF
    {
        $first = $bookings->first();
        $totalAmount = $bookings->sum('grand_total');
        
        // Eager load services
        $bookings->load('bookingServices.service');

        $data = [
            'bookings' => $bookings,
            'first_booking' => $first,
            'total_amount' => $totalAmount,
            'invoice_number' => $this->generateInvoiceNumber($first),
            'generated_at' => Carbon::now(),
            'company' => [
                'name' => setting('admin_title', 'Sân Cầu Lông Niên Thời'),
                'address' => setting('company_address', '123 Đường ABC, Quận 1, TP.HCM'),
                'phone' => setting('company_phone', '0901234567'),
                'email' => setting('email_from_address', 'info@sancaulong.vn'),
            ],
        ];

        $pdf = Pdf::loadView('plugins/court-booking::invoice-grouped-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }

    /**
     * Send grouped invoice via email
     */
    public static function sendGroupedEmail($bookings, ?string $email = null)
    {
        error_log('[INVOICE EMAIL] sendGroupedEmail() called, count=' . $bookings->count() . ', email=' . $email);
        \Log::info('[INVOICE EMAIL] sendGroupedEmail() called', [
            'bookings_count' => $bookings->count(),
            'email_param' => $email,
        ]);

        if ($bookings->isEmpty()) {
            error_log('[INVOICE EMAIL] SKIPPED: bookings collection is empty');
            \Log::warning('[INVOICE EMAIL] SKIPPED: bookings collection is empty');
            return;
        }

        // Prevent duplicate emails (check if already sent)
        if ($bookings->first()->invoice_created_at) {
            error_log('[INVOICE EMAIL] SKIPPED: invoice already created at ' . $bookings->first()->invoice_created_at);
            \Log::warning('[INVOICE EMAIL] SKIPPED: invoice already created at ' . $bookings->first()->invoice_created_at);
            return;
        }

        $service = new self();
        $first = $bookings->first();
        $email = $email ?: $first->email;

        // Fallback email from contact if valid
        if (!$email && filter_var($first->contact, FILTER_VALIDATE_EMAIL)) {
            $email = $first->contact;
        }

        if (!$email) {
            error_log('[INVOICE EMAIL] No email found for order ' . $first->order_code);
            return;
        }

        try {
            $mailFromAddress = env('MAIL_FROM_ADDRESS', config('mail.from.address'));
            $mailFromName = env('MAIL_FROM_NAME', config('mail.from.name', 'Sân Cầu Lông'));

            // Strip quotes that might be accidentally included in env vars
            $mailFromName = trim((string) $mailFromName, '"\'');

            error_log('[INVOICE EMAIL] Mail config: mailer=' . config('mail.default') . ' from=' . $mailFromAddress . ' to=' . $email);

            error_log('[INVOICE EMAIL] Generating PDF...');
            $pdf = $service->generateGroupedPdf($bookings);
            $filename = 'hoa-don-' . ($first->order_code ?? 'order') . '.pdf';
            error_log('[INVOICE EMAIL] PDF generated: ' . $filename);

            error_log('[INVOICE EMAIL] Sending email to ' . $email . '...');
            Mail::send('plugins/court-booking::emails.invoice-grouped', [
                'bookings' => $bookings,
                'email' => $email,
                'company_name' => setting('admin_title', 'Sân Cầu Lông'),
            ], function ($message) use ($email, $first, $pdf, $filename, $mailFromAddress, $mailFromName) {
                $message->from($mailFromAddress, $mailFromName)
                    ->to($email)
                    ->subject('Hóa đơn đặt sân - ' . ($first->order_code ?? 'Order'))
                    ->attachData($pdf->output(), $filename, [
                        'mime' => 'application/pdf',
                    ]);
            });
            
            error_log('[INVOICE EMAIL] Successfully sent to ' . $email);
            
            // Mark all as invoiced
            foreach($bookings as $b) {
                $b->update(['invoice_created_at' => Carbon::now()]);
            }

        } catch (\Throwable $e) {
            error_log('[INVOICE EMAIL FAILED] ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
        }
    }
}
