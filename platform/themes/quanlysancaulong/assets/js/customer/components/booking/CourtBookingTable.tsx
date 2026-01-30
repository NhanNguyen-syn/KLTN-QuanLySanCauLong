import { defineComponent, PropType, ref } from 'vue'
import type { Court, TimePeriod } from './constants'

export default defineComponent({
    name: 'CourtBookingTable',
    props: {
        courts: { type: Array as PropType<Court[]>, required: true },
        periods: { type: Array as PropType<TimePeriod[]>, required: true },
        allTimeSlots: { type: Array as PropType<string[]>, required: true },
        getSlotStatus: { type: Function as PropType<(courtId: string, time: string) => string>, required: true },
        onToggleSlot: { type: Function as PropType<(courtId: string, time: string) => void>, required: true },
    },
    setup(props) {
        const hoveredSlot = ref<string | null>(null)

        const getPeriodForTime = (time: string) => props.periods.find((p) => p.times.includes(time))

        const getButtonClass = (status: string) => {
            const base = 'slot-button'
            if (status === 'booked') return `${base} booked`
            if (status === 'closed') return `${base} closed`
            if (status === 'selected') return `${base} selected`
            return `${base} available`
        }

        const LegendItem = ({ className, text }: { className: string, text: string }) => (
            <div class="legend-item">
                <div class={['legend-box', className]}></div>
                <span class="legend-text">{text}</span>
            </div>
        )

        return () => (
            <div class="court-booking-table-wrapper">
                <div class="court-booking-table-container">
                    <table class="court-booking-table">
                        <thead>
                            <tr class="table-header-row">
                                <th class="court-header-cell">Sân</th>
                                {props.allTimeSlots.map((time) => {
                                    const period = getPeriodForTime(time)
                                    return (
                                        <th key={time} class="time-header-cell">
                                            <div class="time-value">{time}</div>
                                            {period && <div class="time-period">{period.period}</div>}
                                        </th>
                                    )
                                })}
                            </tr>
                        </thead>
                        <tbody>
                            {props.courts.map((court, courtIdx) => (
                                <tr key={court.id} class={['court-row', { 'is-odd': courtIdx % 2 !== 0 }]}>
                                    <td class="court-info-cell">
                                        <div class="court-info">
                                            <span class="court-icon">{(court as any).icon || '🏸'}</span>
                                            <div>
                                                <div class="court-name">{(court as any).name}</div>
                                                <div class="court-price">{Number((court as any).price ?? 0).toLocaleString()}đ/h</div>
                                            </div>
                                        </div>
                                    </td>
                                    {props.allTimeSlots.map((time) => {
                                        const slotKey = `${court.id}-${time}`
                                        const status = props.getSlotStatus(court.id, time)
                                        const isSelected = status === 'selected'
                                        const isBooked = status === 'booked'
                                        const isClosed = status === 'closed'

                                        return (
                                            <td key={slotKey} class="slot-cell">
                                                <button
                                                    onClick={() => props.onToggleSlot(court.id, time)}
                                                    onMouseenter={() => hoveredSlot.value = slotKey}
                                                    onMouseleave={() => hoveredSlot.value = null}
                                                    disabled={isBooked || isClosed}
                                                    class={getButtonClass(status)}
                                                    aria-label={`${court.name} at ${time} - ${status}`}
                                                    aria-pressed={isSelected}
                                                >
                                                    {isSelected && <span class="slot-icon">✓</span>}
                                                    {isBooked && <span class="slot-text">Đã đặt</span>}
                                                    {isClosed && <span class="slot-text">Đóng</span>}
                                                    {!isBooked && !isClosed && !isSelected && hoveredSlot.value === slotKey && (
                                                        <span class="slot-icon">+</span>
                                                    )}
                                                </button>
                                            </td>
                                        )
                                    })}
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                <div class="table-legend">
                    <LegendItem className="available" text="Trống" />
                    <LegendItem className="booked" text="Đã đặt" />
                    <LegendItem className="selected" text="Đã chọn" />
                    <LegendItem className="closed" text="Đóng cửa" />
                </div>
            </div>
        )
    },
})

