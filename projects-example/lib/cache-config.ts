export const CACHE_CONFIG = {
  // Static rendering - cache indefinitely
  STATIC_PAGE: {
    revalidate: false,
  },
  // Revalidate daily
  DAILY: {
    revalidate: 86400,
  },
  // Revalidate hourly
  HOURLY: {
    revalidate: 3600,
  },
  // Revalidate every 5 minutes
  FREQUENT: {
    revalidate: 300,
  },
  // No caching - always fresh
  NO_CACHE: {
    revalidate: 0,
  },
}
