import { defineComponent, ref, computed } from 'vue';

interface User {
  id: number;
  name: string;
  email: string;
}

export default defineComponent({
  name: 'HelloWorld',
  setup() {
    const count = ref<number>(0);
    const users = ref<User[]>([
      { id: 1, name: 'Nguyễn Văn A', email: 'a@example.com' },
      { id: 2, name: 'Trần Thị B', email: 'b@example.com' },
      { id: 3, name: 'Lê Văn C', email: 'c@example.com' },
    ]);

    const doubleCount = computed(() => count.value * 2);

    const increment = () => {
      count.value++;
    };

    const decrement = () => {
      count.value--;
    };

    return () => (
      <div class="hello-world bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Component Demo với TSX</h2>
        
        {/* Counter Section */}
        <div class="counter-section mb-6 p-4 bg-gray-100 rounded">
          <h3 class="text-xl mb-3">Counter Example</h3>
          <p class="mb-2">Count: <strong>{count.value}</strong></p>
          <p class="mb-3">Double Count: <strong>{doubleCount.value}</strong></p>
          <div class="flex gap-2">
            <button
              onClick={increment}
              class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
            >
              Tăng +
            </button>
            <button
              onClick={decrement}
              class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition"
            >
              Giảm -
            </button>
          </div>
        </div>

        {/* Users List Section */}
        <div class="users-section">
          <h3 class="text-xl mb-3">Danh sách Users</h3>
          <div class="grid gap-3">
            {users.value.map((user) => (
              <div
                key={user.id}
                class="user-card p-3 border border-gray-300 rounded hover:shadow-md transition"
              >
                <p class="font-semibold">{user.name}</p>
                <p class="text-sm text-gray-600">{user.email}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    );
  },
});

