import { createApp } from 'vue';
import BannerPage from './components/BannerPage';
import BannerForYard from './components/BannerForYard';
import CourtPricing from './components/CourtPricing';
import WhyChoose from './components/WhyChoose';
import Testimonials from './components/Testimonials';

import WhyChooseUs from './components/WhyChooseUs';
import DetailedPrice from './components/DetailedPrice';
import BookingBadmintonCourt from './components/BookingBadmintonCourt';
import SelectMembership from './components/SelectMembership';
import ContactUs from './components/ContactUs';
import AskedQuestions from './components/AskedQuestions';
import BlogPost from './components/BlogPost';




document.addEventListener('DOMContentLoaded', () => {
    // Banner Page (đang có sẵn)
    const bannerContainers = document.querySelectorAll('[id^="shortcode-banner-page-"]');
    bannerContainers.forEach((container) => {
        const propsData = container.getAttribute('data-props');
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(BannerPage, props);
                app.mount(container as Element);
            } catch (error) {
                console.error('Error parsing banner-page props:', error);
            }
        }
    });

    // Banner For Yard (mới)
    const bannerForYardContainers = document.querySelectorAll('[id^="shortcode-banner-for-yard-"]');
    bannerForYardContainers.forEach((container) => {
        const propsData = (container as HTMLElement).getAttribute('data-props');
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(BannerForYard, props);
                app.mount(container as Element);
            } catch (e) {
                console.error('Failed to parse banner-for-yard props:', e);
            }
        }
    });

    const courtPricingContainers = document.querySelectorAll('[id^="shortcode-court-pricing-"]');
    courtPricingContainers.forEach((container) => {
        const propsData = (container as HTMLElement).dataset.props;
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(CourtPricing, props);
                app.mount(container);
            } catch (e) {
                console.error('Failed to parse court pricing props:', e);
            }
        }
    });

    // Why Choose
    const whyChooseContainers = document.querySelectorAll('[id^="shortcode-why-choose-"]');
    whyChooseContainers.forEach((container) => {
        const propsData = (container as HTMLElement).dataset.props;
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(WhyChoose, props);
                app.mount(container);
            } catch (e) {
                console.error('Failed to parse why-choose props:', e);
            }
        }
    });

    // Testimonials
    const testimonialsContainers = document.querySelectorAll('[id^="shortcode-testimonials-"]');
    testimonialsContainers.forEach((container) => {
        const propsData = (container as HTMLElement).dataset.props;
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(Testimonials, props);
                app.mount(container);
            } catch (e) {
                console.error('Failed to parse testimonials props:', e);
            }
        }
    });

    // Detailed Price
    const detailedPriceContainers = document.querySelectorAll('[id^="shortcode-detailed-price-"]');
    console.log('Found detailed-price containers:', detailedPriceContainers.length);
    detailedPriceContainers.forEach((container) => {
        console.log('Processing container:', container);
        const propsData = (container as HTMLElement).dataset.props || (container as HTMLElement).getAttribute('data-props');
        console.log('Props data:', propsData);
        if (propsData) {
            try {
                const props = JSON.parse(propsData as string);
                console.log('Parsed props:', props);
                const app = createApp(DetailedPrice, props);
                app.mount(container);
                console.log('Mounted successfully');
            } catch (e) {
                console.error('Failed to parse detailed-price props:', e);
            }
        } else {
            console.warn('No props data found for container:', container);
        }
    });



    // Why Choose Us
    const whyChooseUsContainers = document.querySelectorAll('.shortcode-why-choose-us');
    whyChooseUsContainers.forEach((container) => {
        const propsData = (container as HTMLElement).dataset;
        if (propsData) {
            try {
                const props = {
                    title: propsData.title || '',
                    subtitle: propsData.subtitle || '',
                    titleColor: (propsData as any).titleColor || '#0E6B5C',
                    subtitleColor: (propsData as any).subtitleColor || '#6c757d',
                    tabs: propsData.tabs || '[]',
                };
                const app = createApp(WhyChooseUs, props);
                app.mount(container);
            } catch (e) {
                console.error('Failed to parse why-choose-us props:', e);
            }
        }
    });

    // Booking Badminton Court
    const bookingContainers = document.querySelectorAll('[id^="shortcode-booking-badminton-court-"]');
    console.log('Found booking-badminton-court containers:', bookingContainers.length);
    bookingContainers.forEach((container) => {
        const propsData = (container as HTMLElement).getAttribute('data-props') || (container as HTMLElement).dataset.props;
        if (!propsData) {
            console.warn('No props data found for booking container:', container);
            return;
        }
        try {
            const props = JSON.parse(propsData as string);
            console.log('Parsed booking props:', props);

            const app = createApp(BookingBadmintonCourt, props);
            app.mount(container as Element);
        } catch (e) {
            console.error('Failed to parse booking-badminton-court props:', e);
        }
    });

    // Select Membership
    const selectMembershipContainers = document.querySelectorAll('[id^="shortcode-select-membership-"]');
    selectMembershipContainers.forEach((container) => {
        const propsData = (container as HTMLElement).getAttribute('data-props');
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(SelectMembership, props);
                app.mount(container as Element);
            } catch (e) {
                console.error('Failed to parse select-membership props:', e);
            }
        }
    });

    // Asked Questions
    const askedQuestionsContainers = document.querySelectorAll('[id^="shortcode-asked-questions-"]');
    askedQuestionsContainers.forEach((container) => {
        const propsData = (container as HTMLElement).getAttribute('data-props');
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(AskedQuestions, props);
                app.mount(container as Element);



            } catch (e) {
                console.error('Failed to parse asked-questions props:', e);
            }
        }
    });

    // Blog Post
    const blogPostContainers = document.querySelectorAll('[id^="shortcode-blog-post-"]');
    blogPostContainers.forEach((container) => {
        const propsData = (container as HTMLElement).getAttribute('data-props');
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(BlogPost, props);
                app.mount(container as Element);
            } catch (e) {
                console.error('Failed to parse blog-post props:', e);
            }
        }
    });


    // Contact Us
    const contactUsContainers = document.querySelectorAll('[id^="shortcode-contact-us-"]');
    contactUsContainers.forEach((container) => {
        const propsData = (container as HTMLElement).getAttribute('data-props');
        if (propsData) {
            try {
                const props = JSON.parse(propsData);
                const app = createApp(ContactUs, props);
                app.mount(container as Element);
            } catch (e) {
                console.error('Failed to parse contact-us props:', e);
            }
        }
    });


});


