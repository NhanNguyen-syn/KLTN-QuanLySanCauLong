import { defineComponent, PropType, computed } from 'vue'

// React version provided by user has props: selectedSlots, courts, onCheckout
// We keep the same API but in Vue TSX

type CourtLite = { id: string; name: string; price: number }

export default defineComponent({
    name: 'BookingSummary',
    props: {
        selectedSlots: { type: Array as PropType<string[]>, required: true },
        courts: { type: Array as PropType<CourtLite[]>, required: true },
        onCheckout: { type: Function as PropType<() => void>, required: true },
    },
    setup(props) {
        const totalInfos = computed(() => {
            let originalSum = 0
            let finalSum = 0
            const slotCount = props.selectedSlots.length

            for (const slot of props.selectedSlots) {
                const courtId = slot.substring(0, slot.lastIndexOf('-'))
                const court = props.courts.find((c) => String(c.id) === courtId)
                if (court) {
                    const originalSlotPrice = court.price / 2 // Standard price per 30 mins
                    let slotPrice = originalSlotPrice

                    // Apply discount: reduce 10k per slot (20k/hr) if 4+ slots
                    if (slotCount >= 4) {
                        // Assuming the user meant standard 15% or 20k/hr reduction. Let's just deduct 10,000 VND per slot, or 15%.
                        // Original request: "giảm 120.000đ trên 1 giờ chơi thay vì 140.000đ" -> meaning court.price is 140k/hr, and it becomes 120k/hr. So a 20k/hr discount.
                        // Let's do: (court.price / 2) - 10000 if price is >= 100000, or explicitly mapping:
                        slotPrice = Math.max(0, originalSlotPrice - 10000)
                    }

                    originalSum += originalSlotPrice
                    finalSum += slotPrice
                }
            }

            const hasDiscount = finalSum < originalSum
            const percentage = hasDiscount && originalSum > 0 ? Math.round(((originalSum - finalSum) / originalSum) * 100) : 0

            return {
                originalSum,
                finalSum,
                hasDiscount,
                percentage
            }
        })

        const ShoppingBag = () => (
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                <line x1="3" y1="6" x2="21" y2="6" />
                <path d="M16 10a4 4 0 0 1-8 0" />
            </svg>
        )

        const ChevronRight = () => (
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
        )

        return () => (
            props.selectedSlots.length > 0 ? (
                <>
                    <div class="booking-summary-bar">
                        <div class="container">
                            <div class="summary-content">
                                <div class="summary-details">
                                    <div class="summary-item-count">
                                        <div class="summary-icon-wrapper">
                                            <ShoppingBag />
                                        </div>
                                        <div>
                                            <div class="summary-label">Đã chọn</div>
                                            <div class="summary-value-large">{props.selectedSlots.length} khung giờ</div>
                                        </div>
                                    </div>
                                    <div class="summary-divider"></div>
                                    <div class="summary-total-price">
                                        <div class="summary-label">
                                            Tổng tiền
                                            {totalInfos.value.hasDiscount && (
                                                <span class="badge bg-success ms-2 text-white px-2 py-1 rounded" style={{ fontSize: '0.8rem' }}>
                                                    Giảm {totalInfos.value.percentage}%
                                                </span>
                                            )}
                                        </div>
                                        <div class="summary-value-xl">
                                            {totalInfos.value.hasDiscount && (
                                                <span class="text-decoration-line-through text-muted small me-2" style={{ fontSize: '1rem', fontWeight: 'normal' }}>
                                                    {totalInfos.value.originalSum.toLocaleString('vi-VN')}đ
                                                </span>
                                            )}
                                            {totalInfos.value.finalSum.toLocaleString('vi-VN')}đ
                                        </div>
                                    </div>
                                </div>
                                <button
                                    onClick={() => props.onCheckout()}
                                    class="summary-checkout-button"
                                >
                                    Tiếp Tục
                                    <ChevronRight />
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="booking-summary-spacer"></div>
                </>
            ) : null
        )
    },
})

