<x-app1>
  <div x-data="taskManager()" class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <x-page-header />
      <div>
        <button @click="openAdd = true" class="px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
          <span class="mr-2">➕</span> Add Task
        </button>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm flex flex-col sm:flex-row sm:flex-nowrap gap-3 items-center">
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
        <option value="Open">Open</option>
        <option value="In Progress">In Progress</option>
        <option value="On Hold">On Hold</option>
        <option value="Closed">Completed</option>
      </select>

      <button @click="clearFilters"
        class="px-3 py-2 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition ml-auto relative z-20 flex-shrink-0">
        <span class="mr-2">♻️</span> Clear
      </button>
    </div>

    <!-- Task List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
      <ul class="space-y-2">

        <!-- Desktop Rows -->
        <template x-for="task in filteredTasks" :key="task.id">
          <li class="flex flex-col md:flex-row md:items-center justify-between p-3 rounded-md border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <div class="flex-1 min-w-0 md:pr-4">
              <div class="font-medium text-gray-800 dark:text-gray-100 break-words" x-text="task.title"></div>
              <div class="text-xs text-gray-500 truncate">
                Assigned to: <span x-text="task.assignedTo"></span> •
                Due: <span x-text="task.dueDate"></span> •
                Priority: <span x-text="task.priority"></span>
              </div>
              <div class="text-sm text-gray-600 mt-1 whitespace-pre-wrap break-words" x-text="task.notes ? (task.notes.length > 200 ? task.notes.substring(0,200) + '...' : task.notes) : ''"></div>
            </div>
            <div class="flex-shrink-0 flex items-center gap-3 mt-2 md:mt-0 relative z-20">

                      <span class="text-xs px-2 py-1 rounded-full"
                        :class="task.status === 'Closed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
                        x-text="task.status === 'Closed' ? 'Completed' : task.status"></span>

                  <!-- Start button only for Open tasks -->
                  

              <button @click="openEdit(task)"
                class="px-2 py-1 bg-amber-600 text-white rounded shadow hover:bg-amber-700">
                 <span class="mr-2">✏️</span> Edit
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
              <input x-model="newTask.TaskTitle" required
                     class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
          </div>
            <!-- Patient selector removed as requested -->
            <div>
              <label class="text-sm text-gray-500">Notes</label>
              <textarea x-model="newTask.TaskNotes" rows="3" class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2"></textarea>
            </div>
          <div>
            <label class="text-sm text-gray-500">Assign to</label>
              <select x-model="newTask.TaskAssignedTo" class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                <option>Self</option>
                <option>Patient</option>
                <option>Assistant</option>
                <option>Team Leader</option>
              </select>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="text-sm text-gray-500">Due Date</label>
                <input x-model="newTask.DueDate" type="date"
                       class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
            </div>
            <div>
              <label class="text-sm text-gray-500">Priority</label>
                <select x-model="newTask.TaskPrioity"
                      class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                  <option>Low</option>
                  <option selected>Medium</option>
                  <option>High</option>
                  <option>Urgent</option>
              </select>
            </div>
          </div>
            <div>
              <label class="text-sm text-gray-500">Status</label>
              <select x-model="newTask.TaskStatus" class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                <option>Open</option>
                <option>In Progress</option>
                <option>On Hold</option>
                <option value="Closed">Completed</option>
              </select>
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
          <p><strong>Status:</strong> <span x-text="selectedTask.status === 'Closed' ? 'Completed' : selectedTask.status"></span></p>
        </div>
        <div class="flex justify-end gap-2 mt-4 flex-col sm:flex-row">
          <!-- Show Mark as Completed for non-closed tasks -->
          <button x-show="selectedTask.status !== 'Closed'" @click="markCompleted()"
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
              <input x-model="editTask.TaskTitle"
                   class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
          </div>
          <div>
            <label class="text-sm text-gray-500">Assign to</label>
              <select x-model="editTask.TaskAssignedTo" class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                <option>Self</option>
                <option>Patient</option>
                <option>Assistant</option>
                <option>Team Leader</option>
              </select>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="text-sm text-gray-500">Due Date</label>
                <input x-model="editTask.DueDate" type="date"
                     class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
            </div>
            <div>
              <label class="text-sm text-gray-500">Priority</label>
                <select x-model="editTask.TaskPrioity"
                      class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                  <option>Low</option>
                  <option>Medium</option>
                  <option>High</option>
                  <option>Urgent</option>
              </select>
            </div>
          </div>
          <div>
            <label class="text-sm text-gray-500">Status</label>
              <select x-model="editTask.TaskStatus"
                      class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 px-3 py-2">
                <option>Open</option>
                <option>In Progress</option>
                <option>On Hold</option>
                <option value="Closed">Completed</option>
            </select>
          </div>
          <div class="flex justify-end gap-2 mt-4 flex-col sm:flex-row">
            <button type="button" @click="openEditModal = false"
            class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">❌ Cancel</button>
              <button type="button" @click="deleteTask()" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
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
        newTask: { TaskTitle:'', TaskNotes:'', TaskAssignedTo:'Self', DueDate:'', TaskPrioity:'Medium', TaskStatus:'Open' },
        tasks: (function(){
          // server-provided tasks -> normalize to UI shape
          const raw = @json($tasks ?? []);
          return raw.map(t => ({
            id: t.ID,
            TaskModel: t, // keep original
            title: t.TaskTitle || '',
            assignedTo: t.TaskAssignedTo || '',
            dueDate: t.DueDate || '',
            priority: t.TaskPrioity || '',
            status: t.TaskStatus || '',
            notes: t.TaskNotes || '',
            PatientUserID: t.PatientUserID || null,
          }));
        })(),
        patients: @json($patients ?? []),

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

        async addTask() {
          try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const payload = {
              TaskTitle: this.newTask.TaskTitle,
              TaskNotes: this.newTask.TaskNotes || null,
              TaskAssignedTo: this.newTask.TaskAssignedTo,
              DueDate: this.newTask.DueDate || null,
              TaskPrioity: this.newTask.TaskPrioity || 'Medium',
              TaskStatus: this.newTask.TaskStatus || 'Open',
            };

            const res = await fetch('/mod-10/my-tasks/store', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
              },
              body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (!res.ok) throw new Error(data.error || 'Create failed');

            const t = data.task;
            this.tasks.push({
              id: t.ID,
              TaskModel: t,
              title: t.TaskTitle,
              assignedTo: t.TaskAssignedTo,
              dueDate: t.DueDate,
              priority: t.TaskPrioity,
              status: t.TaskStatus,
              notes: t.TaskNotes,
              PatientUserID: t.PatientUserID || null,
            });

            this.newTask = { TaskTitle:'', TaskNotes:'', TaskAssignedTo:'Self', DueDate:'', TaskPrioity:'Medium', TaskStatus:'Open' };
            this.openAdd = false;
          } catch (err) {
            alert('Error creating task: ' + err.message);
          }
        },

        openStart(task) {
          this.selectedTask = task;
          this.openStartModal = true;
        },

        async markCompleted() {
          // mark as Closed
          const task = this.selectedTask;
          try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const payload = { ID: task.id, TaskStatus: 'Closed' };
            const res = await fetch('/mod-10/my-tasks/update', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
              body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.error || 'Update failed');
            task.status = 'Closed';
            this.openStartModal = false;
          } catch (err) {
            alert('Error updating task: ' + err.message);
          }
        },

        openEdit(task) {
          // prepare editTask using DB field names
          this.editTask = {
            ID: task.id,
            TaskTitle: task.title,
            TaskAssignedTo: task.assignedTo,
            DueDate: task.dueDate,
            TaskPrioity: task.priority || 'Medium',
            TaskStatus: task.status || 'Open',
            TaskNotes: task.notes || '',
            PatientUserID: task.PatientUserID || null,
          };
          this.openEditModal = true;
        },

        async updateTask() {
          try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const payload = { ...this.editTask };
            const res = await fetch('/mod-10/my-tasks/update', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
              body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.error || 'Update failed');

            // update local list
            const idx = this.tasks.findIndex(t => t.id === this.editTask.ID);
            if (idx !== -1) {
              const t = data.task;
              this.tasks[idx] = {
                id: t.ID,
                TaskModel: t,
                title: t.TaskTitle,
                assignedTo: t.TaskAssignedTo,
                dueDate: t.DueDate,
                priority: t.TaskPrioity,
                status: t.TaskStatus,
                notes: t.TaskNotes,
                PatientUserID: t.PatientUserID || null,
              };
            }

            this.openEditModal = false;
          } catch (err) {
            alert('Error updating task: ' + err.message);
          }
        },

        async deleteTask() {
          if (!confirm('Delete this task?')) return;
          try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch('/mod-10/my-tasks/delete', {
              method: 'DELETE',
              headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
              body: JSON.stringify({ ID: this.editTask.ID })
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.error || 'Delete failed');

            this.tasks = this.tasks.filter(t => t.id !== this.editTask.ID);
            this.openEditModal = false;
          } catch (err) {
            alert('Error deleting task: ' + err.message);
          }
        }
      }
    }
  </script>
</x-app1>
