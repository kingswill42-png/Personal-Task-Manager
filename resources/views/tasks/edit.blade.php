<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT QUEST // SYSTEM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #050505; 
            color: #e4e4e7;
        }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        .monarch-box {
            background-color: #09090b;
            border: 1px solid #1f1f22;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        }
        .monarch-input {
            background-color: #000000;
            border: 1px solid #1f1f22;
            color: #ffffff;
            transition: all 0.2s ease;
        }
        .monarch-input:focus {
            border-color: #9333ea;
            box-shadow: 0 0 10px rgba(147, 51, 234, 0.2);
            outline: none;
        }
        .btn-arise {
            background-color: transparent;
            color: #a855f7;
            border: 1px solid #a855f7;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .btn-arise:hover {
            background-color: #a855f7;
            color: #000000;
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.4);
        }
        ::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
            opacity: 0.5;
        }
        ::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
    </style>
</head>
<body class="min-h-screen p-6 md:p-12 flex items-center justify-center selection:bg-purple-600 selection:text-white">

    <div class="max-w-xl w-full">
        
        <div class="mb-6 flex items-center justify-between font-mono">
            <div class="flex items-center space-x-3">
                <span class="px-2 py-0.5 bg-purple-900/30 border border-purple-500/50 text-purple-400 text-[10px] font-bold uppercase shadow-[0_0_8px_rgba(147,51,234,0.2)]">EDIT</span>
                <h1 class="text-sm font-semibold tracking-wider text-white uppercase drop-shadow-[0_0_5px_rgba(147,51,234,0.3)]">// QUEST PARAMETERS</h1>
            </div>
            <a href="{{ route('tasks.index') }}" class="text-xs text-zinc-500 hover:text-purple-400 transition-colors flex items-center space-x-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>RETURN</span>
            </a>
        </div>

        <div class="monarch-box p-6 md:p-8 border-t-2 border-t-purple-600">
            <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1.5">Quest Title</label>
                    <input type="text" name="task_name" value="{{ $task->task_name }}" required class="w-full p-3.5 monarch-input text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1.5">System Notes / Conditions</label>
                    <textarea name="description" rows="3" class="w-full p-3.5 monarch-input text-sm resize-none">{{ $task->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1.5">Status</label>
                        <select name="status" class="w-full p-3.5 monarch-input text-sm">
                            <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Active (Pending)</option>
                            <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Cleared (Completed)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1.5">Time Limit</label>
                        <input type="date" name="due_date" value="{{ $task->due_date }}" class="w-full p-3.5 monarch-input text-sm text-zinc-300">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 mt-2 border-t border-zinc-800/50">
                    <a href="{{ route('tasks.index') }}" class="px-4 py-3 text-xs font-mono text-zinc-500 hover:text-white transition-colors uppercase">
                        Abort
                    </a>
                    <button type="submit" class="btn-arise px-6 py-3 text-xs font-mono uppercase tracking-wider">
                        Update Data
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>
</html>