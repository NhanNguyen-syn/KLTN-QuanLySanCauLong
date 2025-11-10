import { Component } from 'vue'
import BannerPage from '../components/shortcodes/BannerPage'

export type ShortcodeName = 'banner-page'

export const shortcodeRegistry: Record<string, Component> = {
  'banner-page': BannerPage,
}

export default shortcodeRegistry

