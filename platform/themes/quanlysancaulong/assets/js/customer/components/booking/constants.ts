export type Court = {
  id: string
  name: string
  price: number
  memberPrice: number
  type: string
  icon: string
  features: string[]
  capacity: number
  status: string
}

export type TimePeriod = {
  period: string
  range: string
  times: string[]
  discount: number
}



export const TIME_PERIODS: TimePeriod[] = [
  {
    period: "Sáng sớm",
    range: "5:00 - 8:00",
    times: ["05:00", "05:30", "06:00", "06:30", "07:00", "07:30"],
    discount: 0,
  },
  {
    period: "Buổi sáng",
    range: "8:00 - 12:00",
    times: ["08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30"],
    discount: 0,
  },
  {
    period: "Buổi chiều",
    range: "12:00 - 17:00",
    times: ["12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30"],
    discount: 0,
  },
  {
    period: "Chiều tối",
    range: "17:00 - 20:00",
    times: ["17:00", "17:30", "18:00", "18:30", "19:00", "19:30"],
    discount: 0.1,
  },
  {
    period: "Tối muộn",
    range: "20:00 - 23:00",
    times: ["20:00", "20:30", "21:00", "21:30", "22:00", "22:30"],
    discount: 0.15,
  },
]

export const ALL_TIME_SLOTS = TIME_PERIODS.flatMap(p => p.times)


