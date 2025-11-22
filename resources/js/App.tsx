import { defineComponent, ref } from 'vue';
import HelloWorld from './components/HelloWorld';
import CourtList from './components/CourtList';
import BookingForm from './components/BookingForm';

export default defineComponent({
  name: 'App',
  setup() {
    const message = ref<string>('Hệ thống Quản lý Sân Cầu Lông');
    const activeTab = ref<'demo' | 'courts' | 'booking'>('courts');

    return () => (
      <div id="app" class="min-h-screen bg-gray-50">
        <header class="bg-white shadow-sm mb-8">
          <div class="container mx-auto px-4 py-6">
            <h1 class="text-4xl font-bold text-blue-600 text-center">
              {message.value}
            </h1>
            <p class="text-center text-gray-600 mt-2">
              Vue 3 + TypeScript + TSX + Laravel
            </p>
          </div>
        </header>

        <div class="container mx-auto px-4">
          {/* Tabs */}
          <div class="flex gap-2 mb-6 border-b border-gray-200">
            <button
              onClick={() => (activeTab.value = 'courts')}
              class={`px-4 py-2 font-medium transition ${
                activeTab.value === 'courts'
                  ? 'text-blue-600 border-b-2 border-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Quản lý Sân
            </button>
            <button
              onClick={() => (activeTab.value = 'booking')}
              class={`px-4 py-2 font-medium transition ${
                activeTab.value === 'booking'
                  ? 'text-blue-600 border-b-2 border-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Đặt Sân
            </button>
            <button
              onClick={() => (activeTab.value = 'demo')}
              class={`px-4 py-2 font-medium transition ${
                activeTab.value === 'demo'
                  ? 'text-blue-600 border-b-2 border-blue-600'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              Demo Components
            </button>
          </div>

          {/* Content */}
          <main class="bg-white rounded-lg shadow-sm p-6">
            {activeTab.value === 'courts' && <CourtList />}
            {activeTab.value === 'booking' && <BookingForm />}
            {activeTab.value === 'demo' && <HelloWorld />}
          </main>
        </div>
      </div>
    );
  },
});

