export const COURT_DATA = {
  STANDARD_RATE: 150000,
  MEMBER_RATE: 120000,
  PEAK_RATE: 200000,
  PEAK_MEMBER_RATE: 170000,
  EARLY_RATE: 120000,
  EARLY_MEMBER_RATE: 100000,
  MEMBER_SAVINGS: 30000,
  TOTAL_COURTS: 10,
  CURRENCY: "đ",
}

export const PEAK_HOURS = {
  WEEKDAY: { start: "17:00", end: "20:00", days: "T2-T6" },
  WEEKEND: { start: "17:00", end: "22:00", days: "T7-CN" },
  EARLY: { start: "05:00", end: "09:00" },
}

export const OPERATING_HOURS = {
  weekday: "5:00 - 23:00",
  saturday: "7:00 - 23:00",
  sunday: "7:00 - 22:00",
}

export const CANCELLATION_POLICY = {
  FREE_UNTIL: "2 giờ trước",
  LATE_PENALTY: "50%",
}
