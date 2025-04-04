@extends('layouts.student_layout')
@section('content')
<style>
    .task-card {
        transition: transform 0.2s ease;
    }
    .task-card.draggable {
        cursor: grab;
    }
    .task-card:hover {
        transform: translateY(-2px);
    }
    .task-card.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    .task-card.non-draggable {
        cursor: default;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
    }
    .kanban-column {
        min-height: 400px;
    }
    .task-move-button {
        transition: all 0.2s ease;
    }
    .task-move-button:hover {
        transform: scale(1.2);
    }
    .task-move-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .status-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
    }
    .kanban-column.drag-over {
        background-color: #f3f4f6;
        border: 2px dashed #6b7280;
    }
</style>

<!-- Include Sortable.js -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<div class="mx-auto max-w-screen-2xl p-4 md:px-6 2xl:px-10">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Team Kanban Board</h2>
        
        <!-- Kanban Board -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Todo Column -->
            <div class="bg-gray-50 p-4 rounded-lg shadow kanban-column">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
                    <span class="mr-2">To Do</span>
                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm">
                        {{ count($tasks['todo'] ?? []) }}
                    </span>
                </h3>
                <div class="space-y-4 min-h-[200px]" id="todo" data-status="todo">
                    @foreach($tasks['todo'] ?? [] as $task)
                        <div class="bg-white p-4 rounded-lg shadow-sm task-card relative {{ $task->assigned_to == Auth::id() ? 'draggable' : 'non-draggable' }}" 
                             data-id="{{ $task->id }}"
                             data-assigned="{{ $task->assigned_to == Auth::id() ? 'true' : 'false' }}">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold">{{ $task->title }}</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $task->description }}</p>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Assigned to: {{ $task->assignedTo->name ?? 'Unassigned' }}</span>
                                <span class="text-gray-500">Due: {{ $task->due_date ? $task->due_date->format('M d') : 'No date' }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                       ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- In Progress Column -->
            <div class="bg-gray-50 p-4 rounded-lg shadow kanban-column">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
                    <span class="mr-2">In Progress</span>
                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm">
                        {{ count($tasks['in_progress'] ?? []) }}
                    </span>
                </h3>
                <div class="space-y-4 min-h-[200px]" id="in_progress" data-status="in_progress">
                    @foreach($tasks['in_progress'] ?? [] as $task)
                        <div class="bg-white p-4 rounded-lg shadow-sm task-card relative {{ $task->assigned_to == Auth::id() ? 'draggable' : 'non-draggable' }}" 
                             data-id="{{ $task->id }}"
                             data-assigned="{{ $task->assigned_to == Auth::id() ? 'true' : 'false' }}">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold">{{ $task->title }}</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $task->description }}</p>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Assigned to: {{ $task->assignedTo->name ?? 'Unassigned' }}</span>
                                <span class="text-gray-500">Due: {{ $task->due_date ? $task->due_date->format('M d') : 'No date' }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                       ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Done Column -->
            <div class="bg-gray-50 p-4 rounded-lg shadow kanban-column">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
                    <span class="mr-2">Done</span>
                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm">
                        {{ count($tasks['done'] ?? []) }}
                    </span>
                </h3>
                <div class="space-y-4 min-h-[200px]" id="done" data-status="done">
                    @foreach($tasks['done'] ?? [] as $task)
                        <div class="bg-white p-4 rounded-lg shadow-sm task-card relative {{ $task->assigned_to == Auth::id() ? 'draggable' : 'non-draggable' }}" 
                             data-id="{{ $task->id }}"
                             data-assigned="{{ $task->assigned_to == Auth::id() ? 'true' : 'false' }}">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold">{{ $task->title }}</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $task->description }}</p>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Assigned to: {{ $task->assignedTo->name ?? 'Unassigned' }}</span>
                                <span class="text-gray-500">Due: {{ $task->due_date ? $task->due_date->format('M d') : 'No date' }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                       ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        // Initialize Sortable for each column
        const columns = ['todo', 'in_progress', 'done'];
        
        columns.forEach(status => {
            new Sortable(document.getElementById(status), {
                group: 'tasks',
                animation: 150,
                ghostClass: 'opacity-50',
                dragClass: 'dragging',
                filter: '.non-draggable', // Prevent dragging of non-draggable items
                onStart: function(evt) {
                    // Check if the item is assigned to the current user
                    if (evt.item.dataset.assigned !== 'true') {
                        evt.preventDefault();
                        return;
                    }
                    
                    evt.item.classList.add('dragging');
                    document.querySelectorAll('.kanban-column').forEach(col => {
                        col.addEventListener('dragenter', handleDragEnter);
                        col.addEventListener('dragleave', handleDragLeave);
                    });
                },
                onEnd: function(evt) {
                    // Check if the item is assigned to the current user
                    if (evt.item.dataset.assigned !== 'true') {
                        return;
                    }

                    evt.item.classList.remove('dragging');
                    document.querySelectorAll('.kanban-column').forEach(col => {
                        col.removeEventListener('dragenter', handleDragEnter);
                        col.removeEventListener('dragleave', handleDragLeave);
                        col.classList.remove('drag-over');
                    });

                    const taskId = evt.item.dataset.id;
                    const newStatus = evt.to.dataset.status;
                    const oldStatus = evt.from.dataset.status;

                    if (newStatus !== oldStatus) {
                        // Notify Livewire about the status change
                        Livewire.dispatch('taskMoved', { taskId, newStatus });
                    }

                    // Update order
                    const items = Array.from(evt.to.children)
                        .filter(el => el.dataset.assigned === 'true') // Only include draggable items
                        .map((el, index) => ({
                            value: el.dataset.id,
                            order: index
                        }));
                    
                    if (items.length > 0) {
                        Livewire.dispatch('updateTaskOrder', { items });
                    }
                }
            });
        });

        function handleDragEnter(e) {
            e.currentTarget.classList.add('drag-over');
        }

        function handleDragLeave(e) {
            e.currentTarget.classList.remove('drag-over');
        }

        Livewire.on('task-updated', (event) => {
            Swal.fire({
                icon: 'success',
                title: 'Task Updated!',
                text: event.message,
                timer: 2000,
                showConfirmButton: false
            });
        });
    });
</script>

@endsection