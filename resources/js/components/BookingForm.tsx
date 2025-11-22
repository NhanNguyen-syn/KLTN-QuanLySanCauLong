import { defineComponent, reactive, computed } from 'vue';

interface BookingFormData {
  customerName: string;
  phone: string;
  email: string;
  courtId: string;
  date: string;
  startTime: string;
  duration: number;
}

interface ValidationErrors {
  [key: string]: string;
}

export default defineComponent({
  name: 'BookingForm',
  setup() {
    const formData = reactive<BookingFormData>({
      customerName: '',
      phone: '',
      email: '',
      courtId: '',
      date: '',
      startTime: '',
      duration: 1,
    });

    const errors = reactive<ValidationErrors>({});

    const courts = [
      { id: '1', name: 'Sân 1 - Khu A' },
      { id: '2', name: 'Sân 2 - Khu A' },
      { id: '3', name: 'Sân 3 - Khu B' },
      { id: '4', name: 'Sân 4 - Khu B' },
    ];

    const timeSlots = [
      '06:00',
      '07:00',
      '08:00',
      '09:00',
      '10:00',
      '11:00',
      '12:00',
      '13:00',
      '14:00',
      '15:00',
      '16:00',
      '17:00',
      '18:00',
      '19:00',
      '20:00',
      '21:00',
    ];

    const totalPrice = computed(() => {
      const pricePerHour = 100000;
      return pricePerHour * formData.duration;
    });

    const formatPrice = (price: number) => {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      }).format(price);
    };

    const validateForm = (): boolean => {
      const newErrors: ValidationErrors = {};

      if (!formData.customerName.trim()) {
        newErrors.customerName = 'Vui lòng nhập tên khách hàng';
      }

      if (!formData.phone.trim()) {
        newErrors.phone = 'Vui lòng nhập số điện thoại';
      } else if (!/^[0-9]{10}$/.test(formData.phone)) {
        newErrors.phone = 'Số điện thoại không hợp lệ (10 chữ số)';
      }

      if (!formData.email.trim()) {
        newErrors.email = 'Vui lòng nhập email';
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
        newErrors.email = 'Email không hợp lệ';
      }

      if (!formData.courtId) {
        newErrors.courtId = 'Vui lòng chọn sân';
      }

      if (!formData.date) {
        newErrors.date = 'Vui lòng chọn ngày';
      }

      if (!formData.startTime) {
        newErrors.startTime = 'Vui lòng chọn giờ bắt đầu';
      }

      Object.assign(errors, newErrors);
      return Object.keys(newErrors).length === 0;
    };

    const handleSubmit = (e: Event) => {
      e.preventDefault();

      // Clear previous errors
      Object.keys(errors).forEach((key) => delete errors[key]);

      if (validateForm()) {
        console.log('Form submitted:', formData);
        alert('Đặt sân thành công! Kiểm tra console để xem dữ liệu.');
        // Here you would typically send data to backend
      }
    };

    const resetForm = () => {
      Object.assign(formData, {
        customerName: '',
        phone: '',
        email: '',
        courtId: '',
        date: '',
        startTime: '',
        duration: 1,
      });
      Object.keys(errors).forEach((key) => delete errors[key]);
    };

    return () => (
      <div class="booking-form max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Đặt Sân Cầu Lông</h2>

        <form onSubmit={handleSubmit} class="space-y-4">
          {/* Customer Name */}
          <div>
            <label class="block text-sm font-medium mb-2">
              Tên khách hàng <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              v-model={formData.customerName}
              class={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 ${
                errors.customerName
                  ? 'border-red-500 focus:ring-red-500'
                  : 'border-gray-300 focus:ring-blue-500'
              }`}
              placeholder="Nhập tên khách hàng"
            />
            {errors.customerName && (
              <p class="text-red-500 text-sm mt-1">{errors.customerName}</p>
            )}
          </div>

          {/* Phone */}
          <div>
            <label class="block text-sm font-medium mb-2">
              Số điện thoại <span class="text-red-500">*</span>
            </label>
            <input
              type="tel"
              v-model={formData.phone}
              class={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 ${
                errors.phone
                  ? 'border-red-500 focus:ring-red-500'
                  : 'border-gray-300 focus:ring-blue-500'
              }`}
              placeholder="0123456789"
            />
            {errors.phone && (
              <p class="text-red-500 text-sm mt-1">{errors.phone}</p>
            )}
          </div>

          {/* Email */}
          <div>
            <label class="block text-sm font-medium mb-2">
              Email <span class="text-red-500">*</span>
            </label>
            <input
              type="email"
              v-model={formData.email}
              class={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 ${
                errors.email
                  ? 'border-red-500 focus:ring-red-500'
                  : 'border-gray-300 focus:ring-blue-500'
              }`}
              placeholder="email@example.com"
            />
            {errors.email && (
              <p class="text-red-500 text-sm mt-1">{errors.email}</p>
            )}
          </div>

          {/* Court Selection */}
          <div>
            <label class="block text-sm font-medium mb-2">
              Chọn sân <span class="text-red-500">*</span>
            </label>
            <select
              v-model={formData.courtId}
              class={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 ${
                errors.courtId
                  ? 'border-red-500 focus:ring-red-500'
                  : 'border-gray-300 focus:ring-blue-500'
              }`}
            >
              <option value="">-- Chọn sân --</option>
              {courts.map((court) => (
                <option key={court.id} value={court.id}>
                  {court.name}
                </option>
              ))}
            </select>
            {errors.courtId && (
              <p class="text-red-500 text-sm mt-1">{errors.courtId}</p>
            )}
          </div>

          {/* Date and Time */}
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-2">
                Ngày <span class="text-red-500">*</span>
              </label>
              <input
                type="date"
                v-model={formData.date}
                class={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 ${
                  errors.date
                    ? 'border-red-500 focus:ring-red-500'
                    : 'border-gray-300 focus:ring-blue-500'
                }`}
              />
              {errors.date && (
                <p class="text-red-500 text-sm mt-1">{errors.date}</p>
              )}
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                Giờ bắt đầu <span class="text-red-500">*</span>
              </label>
              <select
                v-model={formData.startTime}
                class={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 ${
                  errors.startTime
                    ? 'border-red-500 focus:ring-red-500'
                    : 'border-gray-300 focus:ring-blue-500'
                }`}
              >
                <option value="">-- Chọn giờ --</option>
                {timeSlots.map((time) => (
                  <option key={time} value={time}>
                    {time}
                  </option>
                ))}
              </select>
              {errors.startTime && (
                <p class="text-red-500 text-sm mt-1">{errors.startTime}</p>
              )}
            </div>
          </div>

          {/* Duration */}
          <div>
            <label class="block text-sm font-medium mb-2">
              Thời lượng (giờ)
            </label>
            <input
              type="number"
              v-model={formData.duration}
              min="1"
              max="4"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          {/* Total Price */}
          <div class="bg-blue-50 p-4 rounded-md">
            <div class="flex justify-between items-center">
              <span class="font-medium">Tổng tiền:</span>
              <span class="text-2xl font-bold text-blue-600">
                {formatPrice(totalPrice.value)}
              </span>
            </div>
          </div>

          {/* Buttons */}
          <div class="flex gap-3 pt-4">
            <button
              type="submit"
              class="flex-1 bg-blue-500 text-white px-6 py-3 rounded-md font-medium hover:bg-blue-600 transition"
            >
              Đặt Sân
            </button>
            <button
              type="button"
              onClick={resetForm}
              class="px-6 py-3 border border-gray-300 rounded-md font-medium hover:bg-gray-50 transition"
            >
              Đặt lại
            </button>
          </div>
        </form>
      </div>
    );
  },
});

