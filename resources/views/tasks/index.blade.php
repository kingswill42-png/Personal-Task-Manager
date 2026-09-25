<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Personal Task Manager</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Task Form -->
        <form action="{{ route('tasks.store') }}" method="POST" class="mb-8 space-y-4 border-b pb-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Task Name</label>
                <input type="text" name="task_name" required class="mt-1 w-full p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="2" class="mt-1 w-full p-2 border rounded-md"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Due Date</label>
                <input type="date" name="due_date" class="mt-1 w-full p-2 border rounded-md">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add Task</button>
        </form>

        <!-- Task List -->
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Task List</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="p-3">Task Name</th>
                        <th class="p-3">Description</th>
                        <th class="p-3">Due Date</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-medium">{{ $task->task_name }}</td>
                            <td class="p-3 text-gray-600">{{ $task->description ?? 'N/A' }}</td>
                            <td class="p-3 text-gray-600">{{ $task->due_date ?? 'No deadline' }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $task->status === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td class="p-3 flex space-x-2">
                                <!-- Status Toggle -->
                                <form action="{{ route('tasks.toggleStatus', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">
                                        Mark {{ $task->status === 'Pending' ? 'Completed' : 'Pending' }}
                                    </button>
                                </form>

                                <!-- Edit -->
                                <a href="{{ route('tasks.edit', $task) }}" class="text-xs bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Edit</a>

                                <!-- Delete -->
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No tasks found. Add one above!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>