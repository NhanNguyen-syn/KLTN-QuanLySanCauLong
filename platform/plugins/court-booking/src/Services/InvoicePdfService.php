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
                'name' => setting('admin_title', 'Sân Cầu Lông ABC'),
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
    public function sendEmail(BookingList $booking, string $email): bool
    {
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

        // Send email if contact looks like email
        if (filter_var($booking->contact, FILTER_VALIDATE_EMAIL)) {
            $service->sendEmail($booking, $booking->contact);
        }
    }
}
