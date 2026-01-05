import { defineComponent, ref, reactive, computed, onMounted } from 'vue';
import axios from 'axios';

interface Court {
  id: string | number;
  name: string;

  // Backend field
  status: 'published' | 'draft' | string;

  // Optional fields (some APIs may include these)
  location?: string;
  type?: string;
  pricePerHour?: number;
  memberPrice?: number;
}

export default defineComponent({
  name: 'CourtList',
  setup() {
    // Danh sách sân lấy từ API
    const courts = ref<Court[]>([]);

    // Tải dữ liệu sân khi component mount
    onMounted(async () => {
      try {
        const { data } = await axios.get('/api/court-booking/courts');
        courts.value = data.data ?? [];
      } catch (err) {
        /* eslint-disable no-console */
        console.error('Failed to fetch courts', err);
      }
    });

    const filter = reactive({
      status: 'all' as 'all' | Court['status'],
      location: 'all',
    });

    const filteredCourts = computed(() => {
      return courts.value.filter((court) => {
        const statusMatch =
          filter.status === 'all' || court.status === filter.status;
        const locationMatch =
          filter.location === 'all' || court.location === filter.location;
        return statusMatch && locationMatch;
      });
    });

    const getStatusColor = (status: Court['status']) => {
      const colors = {
        available: 'bg-green-100 text-green-800',
        occupied: 'bg-red-100 text-red-800',
        maintenance: 'bg-yellow-100 text-yellow-800',
      };
      return colors[status];
    };

    const getStatusText = (status: Court['status']) => {
      const texts = {
        available: 'Có sẵn',
        occupied: 'Đang sử dụng',
        maintenance: 'Bảo trì',
      };
      return texts[status];
    };

    const formatPrice = (price: number) => {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      }).format(price);
    };

    return () => (
      <div class="court-list">
        <h2 class="text-2xl font-bold mb-4">Danh sách Sân Cầu Lông</h2>

        {/* Filters */}
        <div class="filters mb-6 p-4 bg-gray-50 rounded-lg">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-2">Trạng thái:</label>
              <select
                v-model={filter.status}
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="all">Tất cả</option>
                <option value="available">Có sẵn</option>
                <option value="occupied">Đang sử dụng</option>
                <option value="maintenance">Bảo trì</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium mb-2">Khu vực:</label>
              <select
                v-model={filter.location}
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="all">Tất cả</option>
                <option value="Khu A">Khu A</option>
                <option value="Khu B">Khu B</option>
              </select>
            </div>
          </div>
        </div>

        {/* Courts Grid */}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          {filteredCourts.value.map((court) => (
            <div
              key={court.id}
              class="court-card bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow p-4"
            >
              <div class="flex justify-between items-start mb-3">
                <h3 class="text-lg font-semibold">{court.name}</h3>
                <span
                  class={`px-2 py-1 text-xs font-medium rounded-full ${getStatusColor(
                    court.status
                  )}`}
                >
                  {getStatusText(court.status)}
                </span>
              </div>
              <div class="space-y-2 text-sm text-gray-600">
                <p>
                  <span class="font-medium">Khu vực:</span> {court.location}
                </p>
                <p>
                  <span class="font-medium">Giá:</span>{' '}
                  {formatPrice(court.pricePerHour)}/giờ
                </p>
              </div>
              <div class="mt-4">
                <button
                  disabled={court.status !== 'available'}
                  class={`w-full px-4 py-2 rounded-md font-medium transition ${
                    court.status === 'available'
                      ? 'bg-blue-500 text-white hover:bg-blue-600'
                      : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                  }`}
                >
                  {court.status === 'available' ? 'Đặt sân' : 'Không khả dụng'}
                </button>
              </div>
            </div>
          ))}
        </div>

        {filteredCourts.value.length === 0 && (
          <div class="text-center py-8 text-gray-500">
            Không tìm thấy sân nào phù hợp với bộ lọc
          </div>
        )}
      </div>
    );
  },
});

