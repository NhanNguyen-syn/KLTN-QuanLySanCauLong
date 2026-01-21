"use client"

import { type FC, useEffect, useState } from "react"
import { RefreshCw, CheckCircle2 } from "lucide-react"

interface RealTimeUpdateProps {
  lastUpdated: Date
  onRefresh: () => void
  autoRefreshInterval?: number
}

export const RealTimeUpdate: FC<RealTimeUpdateProps> = ({ lastUpdated, onRefresh, autoRefreshInterval = 30000 }) => {
  const [timeAgo, setTimeAgo] = useState<string>("")
  const [isRefreshing, setIsRefreshing] = useState(false)

  useEffect(() => {
    const updateTimeAgo = () => {
      const seconds = Math.floor((new Date().getTime() - lastUpdated.getTime()) / 1000)
      if (seconds < 60) {
        setTimeAgo("Vừa cập nhật")
      } else if (seconds < 3600) {
        const minutes = Math.floor(seconds / 60)
        setTimeAgo(`${minutes} phút trước`)
      } else {
        const hours = Math.floor(seconds / 3600)
        setTimeAgo(`${hours} giờ trước`)
      }
    }

    updateTimeAgo()
    const interval = setInterval(updateTimeAgo, 30000)
    return () => clearInterval(interval)
  }, [lastUpdated])

  useEffect(() => {
    const refreshInterval = setInterval(() => {
      onRefresh()
    }, autoRefreshInterval)
    return () => clearInterval(refreshInterval)
  }, [autoRefreshInterval, onRefresh])

  const handleRefresh = async () => {
    setIsRefreshing(true)
    await new Promise((resolve) => setTimeout(resolve, 500))
    onRefresh()
    setIsRefreshing(false)
  }

  return (
    <div className="flex items-center justify-between p-3 bg-accent/5 border border-accent/20 rounded-lg">
      <div className="flex items-center gap-2">
        <CheckCircle2 className="w-4 h-4 text-accent" />
        <span className="text-xs text-muted-foreground">Cập nhật: {timeAgo}</span>
      </div>
      <button
        onClick={handleRefresh}
        disabled={isRefreshing}
        className="p-1.5 hover:bg-muted rounded transition-colors disabled:opacity-50"
        aria-label="Refresh availability"
      >
        <RefreshCw className={`w-4 h-4 ${isRefreshing ? "animate-spin" : ""}`} />
      </button>
    </div>
  )
}
