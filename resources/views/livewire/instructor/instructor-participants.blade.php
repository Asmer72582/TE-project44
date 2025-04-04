@extends('layouts.instructor_layout')
@section('content')
<style>
    .task-card {
        transition: transform 0.2s ease;
    }
    .task-card:hover {
        transform: translateY(-2px);
    }
    .kanban-column {
        min-height: 400px;
    }
    .processing-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .processing-content {
        background: white;
        padding: 2rem;
        border-radius: 0.5rem;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999;
    }
    .modal.show {
        display: flex;
    }
    .modal-content {
        background: white;
        padding: 2.5rem;
        border-radius: 0.75rem;
        width: 100%;
        max-width: 600px;
        position: relative;
        margin: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .close-button {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
    }
    .close-button:hover {
        color: #000;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background-color: #fff;
    }
    .form-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    .form-input:hover {
        border-color: #cbd5e1;
    }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<!-- Processing Overlay -->
@if($isProcessing)
<div class="processing-overlay" wire:loading.delay wire:target="createTask">
    <div class="processing-content">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary mx-auto mb-4"></div>
        <p class="text-lg font-semibold text-gray-700">Processing...</p>
        <p class="text-sm text-gray-500">Please wait while we create your task.</p>
    </div>
</div>
@endif

<div class="mx-auto max-w-screen-2xl p-4 md:px-6 2xl:px-10">
    <div class="mb-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Team Kanban Board Management</h2>
            <button onclick="toggleModal()" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create New Task
            </button>
        </div>
        
        <!-- Create Task Modal -->
        <div id="taskModal" class="modal">
            <div class="modal-content">
                <button onclick="toggleModal()" class="close-button">&times;</button>
                <h3 class="text-xl font-semibold mb-6">Create New Task</h3>
                <form wire:submit.prevent="createTask" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" wire:model="title" class="form-input" placeholder="Enter task title">
                            @error('title') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Assigned To</label>
                            <select wire:model="assigned_to" class="form-input">
                                <option value="">Select Team Member</option>
                                @foreach($participants as $participant)
                                    <option value="{{ $participant->id }}">{{ $participant->name }}</option>
                                @endforeach
                            </select>
                            @error('assigned_to') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Due Date</label>
                            <input type="date" wire:model="due_date" class="form-input">
                            @error('due_date') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Priority</label>
                            <select wire:model="priority" class="form-input">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 form-group">
                            <label class="form-label">Description</label>
                            <textarea wire:model="description" rows="3" class="form-input" placeholder="Enter task description"></textarea>
                            @error('description') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="toggleModal()" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 font-medium">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed font-medium" wire:loading.attr="disabled" wire:target="createTask">
                            <span wire:loading.remove wire:target="createTask">Create Task</span>
                            <span wire:loading wire:target="createTask">Creating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kanban Board -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Todo Column -->
            <div class="bg-gray-50 p-4 rounded-lg shadow kanban-column">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">To Do</h3>
                <div class="space-y-4">
                    @foreach($tasks['todo'] ?? [] as $task)
                        <div class="bg-white p-4 rounded-lg shadow-sm task-card">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold">{{ $task->title }}</h4>
                                <div class="flex space-x-2">
                                    <button wire:click="updateTaskStatus({{ $task->id }}, 'in_progress')" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <button wire:click="deleteTask({{ $task->id }})" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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
                <h3 class="text-lg font-semibold mb-4 text-gray-700">In Progress</h3>
                <div class="space-y-4">
                    @foreach($tasks['in_progress'] ?? [] as $task)
                        <div class="bg-white p-4 rounded-lg shadow-sm task-card">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold">{{ $task->title }}</h4>
                                <div class="flex space-x-2">
                                    <button wire:click="updateTaskStatus({{ $task->id }}, 'todo')" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                    <button wire:click="updateTaskStatus({{ $task->id }}, 'done')" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <button wire:click="deleteTask({{ $task->id }})" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Done</h3>
                <div class="space-y-4">
                    @foreach($tasks['done'] ?? [] as $task)
                        <div class="bg-white p-4 rounded-lg shadow-sm task-card">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold">{{ $task->title }}</h4>
                                <div class="flex space-x-2">
                                    <button wire:click="updateTaskStatus({{ $task->id }}, 'in_progress')" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                    <button wire:click="deleteTask({{ $task->id }})" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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
    function toggleModal() {
        const modal = document.getElementById('taskModal');
        modal.classList.toggle('show');
    }

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('task-created', (event) => {
            toggleModal(); // Close the modal
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: event.message,
                timer: 2000,
                showConfirmButton: false
            });
        });

        Livewire.on('task-error', (event) => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: event.message
            });
        });

        Livewire.on('task-updated', (event) => {
            Toast.fire({
                icon: 'success',
                title: event.message
            });
        });

        Livewire.on('task-deleted', (event) => {
            Toast.fire({
                icon: 'success',
                title: event.message
            });
        });
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('taskModal');
        if (event.target == modal) {
            toggleModal();
        }
    }
</script>

@endsection