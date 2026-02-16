<x-app1>
    <div x-data="taskManager()" class="space-y-6">
  
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <x-page-header />
        <div>
          <button @click="openAdd = true" class="px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            ➕ Add Task
          </button>
        </div>
      </div>
  
      <!-- Filters -->
      <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm flex flex-col sm:flex-row flex-wrap gap-3 items-center">
        <input type="text" placeholder="Search Task Title..." x-model="filters.title"
               class="w-full sm:w-1/2 md:w-1/4 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2" />
        <input type="text" placeholder="Search Assigned To..." x-model="filters.assignedTo"
               class="w-full sm:w-1/2 md:w-1/4 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2" />
  
        <div class="flex gap-2 w-full sm:w-auto items-center">
          <label class="text-xs text-gray-500">From</label>
          <input type="date" x-model="filters.dateFrom"
                 class="border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2" />
          <label class="text-xs text-gray-500">To</label>
          <input type="date" x-model="filters.dateTo"
                 class="border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2" />
        </div>
  
        <select x-model="filters.status"
                class="border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-sm w-full sm:w-auto p-2">
          <option value="">All Status</option>
          <option value="Pending">Pending</option>
          <option value="Completed">Completed</option>
        </select>
  
        <button @click="clearFilters"
                class="px-3 py-2 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition ml-auto sm:ml-0">
                ♻️ Clear
        </button>
      </div>
  
      <!-- Task List -->
      <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
        <ul class="space-y-2">
  
          <!-- Desktop Rows -->
          <template x-for="task in filteredTasks" :key="task.id">
            <li class="flex flex-col md:flex-row md:items-center justify-between p-3 rounded-md border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
              <div>
                <div class="font-medium text-gray-800 dark:text-gray-100" x-text="task.title"></div>
                <div class="text-xs text-gray-500">
                  Assigned to: <span x-text="task.assignedTo"></span> •
                  Due: <span x-text="task.dueDate"></span> •
                  Priority: <span x-text="task.priority"></span>
                </div>
              </div>
              <div class="flex items-center gap-3 mt-2 md:mt-0">
  
                <span class="text-xs px-2 py-1 rounded-full"
                      :class="task.status === 'Completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
                      x-text="task.status"></span>
  
                <!-- Start button only for Pending tasks -->
                <button x-show="task.status === 'Pending'" @click="openStart(task)"
                        class="px-3 py-1 rounded-md bg-green-600 text-white text-sm hover:bg-green-700">
                  Start
                </button>
  
                <button @click="openEdit(task)"
                        class="px-3 py-1 bg-amber-600 text-white rounded shadow hover:bg-amber-700">
                   ✏️ Edit
                </button>
              </div>
            </li>
          </template>
  
          <div x-show="filteredTasks.length === 0" class="text-center py-6 text-gray-500 text-sm">
            No tasks found for the selected filters.
          </div>
        </ul>
      </div>
  
      <!-- Add Task Modal -->
      <div x-show="openAdd" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40 p-4" x-transition>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-lg">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Add Task</h3>
            <button @click="openAdd = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <form @submit.prevent="addTask" class="space-y-3">
            <div>
              <label class="text-sm text-gray-500">Task Title</label>
              <input x-model="newTask.title" required
                     class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
            </div>
            <div>
              <label class="text-sm text-gray-500">Assign to</label>
              <input x-model="newTask.assignedTo" placeholder="self / staff"
                     class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="text-sm text-gray-500">Due Date</label>
                <input x-model="newTask.dueDate" type="date"
                       class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
              </div>
              <div>
                <label class="text-sm text-gray-500">Priority</label>
                <select x-model="newTask.priority"
                        class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                  <option>Normal</option>
                  <option>High</option>
                  <option>Low</option>
                </select>
              </div>
            </div>
            <div class="flex justify-end gap-2 mt-4 flex-col sm:flex-row">
              <button type="button" @click="openAdd = false"
              class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌ Cancel</button>
              <button type="submit"
                      class="px-3 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">Create</button>
            </div>
          </form>
        </div>
      </div>
  
      <!-- Start Modal -->
      <div x-show="openStartModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40 p-4" x-transition>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-lg">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Task Details</h3>
            <button @click="openStartModal = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
            <p><strong>Title:</strong> <span x-text="selectedTask.title"></span></p>
            <p><strong>Assigned To:</strong> <span x-text="selectedTask.assignedTo"></span></p>
            <p><strong>Due Date:</strong> <span x-text="selectedTask.dueDate"></span></p>
            <p><strong>Priority:</strong> <span x-text="selectedTask.priority"></span></p>
            <p><strong>Status:</strong> <span x-text="selectedTask.status"></span></p>
          </div>
          <div class="flex justify-end gap-2 mt-4 flex-col sm:flex-row">
            <!-- Show only for Pending tasks -->
            <button x-show="selectedTask.status === 'Pending'" @click="markCompleted()"
                    class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
              Mark as Completed
            </button>
            <button @click="openStartModal = false" class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌ Close </button>
          </div>
        </div>
      </div>
  
      <!-- Edit Modal -->
      <div x-show="openEditModal" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-40 p-4" x-transition>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-lg">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Edit Task</h3>
            <button @click="openEditModal = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <form @submit.prevent="updateTask" class="space-y-3">
            <div>
              <label class="text-sm text-gray-500">Task Title</label>
              <input x-model="editTask.title"
                     class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
            </div>
            <div>
              <label class="text-sm text-gray-500">Assign to</label>
              <input x-model="editTask.assignedTo"
                     class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="text-sm text-gray-500">Due Date</label>
                <input x-model="editTask.dueDate" type="date"
                       class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
              </div>
              <div>
                <label class="text-sm text-gray-500">Priority</label>
                <select x-model="editTask.priority"
                        class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                  <option>Normal</option>
                  <option>High</option>
                  <option>Low</option>
                </select>
              </div>
            </div>
            <div>
              <label class="text-sm text-gray-500">Status</label>
              <select x-model="editTask.status"
                      class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                <option>Pending</option>
                <option>Completed</option>
              </select>
            </div>
            <div class="flex justify-end gap-2 mt-4 flex-col sm:flex-row">
              <button type="button" @click="openEditModal = false"
              class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌ Cancel</button>
              <button type="submit"
                      class="px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</button>
            </div>
          </form>
        </div>
      </div>
  
    </div>
  
    <script>
      function taskManager() {
        return {
          openAdd: false,
          openStartModal: false,
          openEditModal: false,
          selectedTask: {},
          editTask: {},
          filters: { title:'', assignedTo:'', dateFrom:'', dateTo:'', status:'' },
          newTask: { title:'', assignedTo:'', dueDate:'', priority:'Normal', status:'Pending' },
          tasks: [
            {id:1, title:'Follow up with Sara — medication review', assignedTo:'Self', dueDate:'2025-10-29', priority:'High', status:'Pending'},
            {id:2, title:'Check patient report updates', assignedTo:'Staff', dueDate:'2025-10-27', priority:'Normal', status:'Completed'},
            {id:3, title:'Prepare therapy notes for Ali', assignedTo:'Self', dueDate:'2025-10-26', priority:'Low', status:'Pending'},
            {id:4, title:'Schedule follow-up call with Zain', assignedTo:'Assistant', dueDate:'2025-10-25', priority:'Normal', status:'Completed'},
            {id:5, title:'Submit weekly report', assignedTo:'Self', dueDate:'2025-10-24', priority:'High', status:'Pending'},
          ],
  
          get filteredTasks() {
            return this.tasks.filter(t => {
              const match = (val, term) => val.toLowerCase().includes(term.toLowerCase());
              const matchesTitle = !this.filters.title || match(t.title, this.filters.title);
              const matchesAssigned = !this.filters.assignedTo || match(t.assignedTo, this.filters.assignedTo);
              const matchesStatus = !this.filters.status || t.status === this.filters.status;
  
              const from = this.filters.dateFrom ? new Date(this.filters.dateFrom) : null;
              const to = this.filters.dateTo ? new Date(this.filters.dateTo) : null;
              const due = new Date(t.dueDate);
              const matchesDate = (!from || due >= from) && (!to || due <= to);
  
              return matchesTitle && matchesAssigned && matchesStatus && matchesDate;
            });
          },
  
          clearFilters() {
            this.filters = { title:'', assignedTo:'', dateFrom:'', dateTo:'', status:'' };
          },
  
          addTask() {
            if(!this.newTask.title) return;
            this.tasks.push({ id: Date.now(), ...this.newTask });
            this.newTask = { title:'', assignedTo:'', dueDate:'', priority:'Normal', status:'Pending' };
            this.openAdd = false;
          },
  
          openStart(task) {
            this.selectedTask = task;
            this.openStartModal = true;
          },
  
          markCompleted() {
            this.selectedTask.status = 'Completed';
            this.openStartModal = false;
          },
  
          openEdit(task) {
            this.editTask = JSON.parse(JSON.stringify(task));
            this.openEditModal = true;
          },
  
          updateTask() {
            const index = this.tasks.findIndex(t=>t.id===this.editTask.id);
            if(index !== -1) this.tasks[index] = { ...this.editTask };
            this.openEditModal = false;
          }
        }
      }
    </script>
  </x-app1>
  