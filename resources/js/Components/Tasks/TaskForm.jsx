import React, { useEffect } from 'react';
import { useForm } from '@inertiajs/react';
import { Save, X } from 'lucide-react';
import { Link } from '@inertiajs/react';

export default function TaskForm({ task = null, mode = 'create' }) {
    const { data, setData, post, put, processing, errors, reset } = useForm({
        title: '',
        description: '',
        status: 'open',
        due_date: '',
    });

    useEffect(() => {
        if (task && Object.keys(task).length > 0) {
            const taskData = task.data || task;
            
            let dueDate = '';
            if (taskData.due_date) {
                dueDate = taskData.due_date.split(' ')[0];
            }
            
            const formData = {
                title: taskData.title || '',
                description: taskData.description || '',
                status: taskData.status?.value || taskData.status || 'open',
                due_date: dueDate,
            };
            setData(formData);
        }
    }, [task]);

    const currentStatus = data.status || 'open';

    const submit = (e) => {
        e.preventDefault();

        if (mode === 'create') {
            post(route('tasks.store'), {
                onSuccess: () => reset(),
            });
        } else {
            const taskId = task?.id || task?.data?.id;
            
            if (!taskId) {
                return;
            }
            
            put(route('tasks.update', taskId), {
                onSuccess: () => reset(),
            });
        }
    };

    return (
        <div className="max-w-3xl mx-auto">
            <div className="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <div className="px-8 py-8 border-b border-gray-100">
                    <h2 className="text-2xl font-bold text-gray-900 mb-2">
                        {mode === 'create' ? 'Nova Tarefa' : 'Editar Tarefa'}
                    </h2>
                    <p className="text-gray-600">
                        {mode === 'create' 
                            ? 'Preencha os dados abaixo para criar uma nova tarefa'
                            : 'Atualize os dados da tarefa'
                        }
                    </p>
                </div>

                <div className="px-8 py-8">
                    <form onSubmit={submit} className="space-y-8">
                        <div>
                            <label htmlFor="title" className="block text-sm font-medium text-gray-700 mb-3">
                                Título *
                            </label>
                            <input
                                id="title"
                                type="text"
                                value={data.title}
                                onChange={(e) => setData('title', e.target.value)}
                                placeholder="Digite o título da tarefa"
                                className={`w-full px-4 py-4 border rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-200 ${
                                    errors.title ? 'border-red-300' : 'border-gray-200'
                                }`}
                                required
                            />
                            {errors.title && (
                                <p className="mt-2 text-sm text-red-600">{errors.title}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="description" className="block text-sm font-medium text-gray-700 mb-3">
                                Descrição *
                            </label>
                            <textarea
                                id="description"
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                placeholder="Digite a descrição da tarefa"
                                rows={5}
                                className={`w-full px-4 py-4 border rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-200 ${
                                    errors.description ? 'border-red-300' : 'border-gray-200'
                                }`}
                                required
                            />
                            {errors.description && (
                                <p className="mt-2 text-sm text-red-600">{errors.description}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="status" className="block text-sm font-medium text-gray-700 mb-3">
                                Status *
                            </label>
                            <select
                                id="status"
                                value={currentStatus}
                                onChange={(e) => setData('status', e.target.value)}
                                className={`w-full px-4 py-4 border rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-200 ${
                                    errors.status ? 'border-red-300' : 'border-gray-200'
                                }`}
                                required
                            >
                                <option value="open">Aberta</option>
                                <option value="done">Concluída</option>
                            </select>
                            {errors.status && (
                                <p className="mt-2 text-sm text-red-600">{errors.status}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="due_date" className="block text-sm font-medium text-gray-700 mb-3">
                                Data de Vencimento
                            </label>
                            <input
                                id="due_date"
                                type="date"
                                value={data.due_date}
                                onChange={(e) => setData('due_date', e.target.value)}
                                className={`w-full px-4 py-4 border rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-200 ${
                                    errors.due_date ? 'border-red-300' : 'border-gray-200'
                                }`}
                            />
                            {errors.due_date && (
                                <p className="mt-2 text-sm text-red-600">{errors.due_date}</p>
                            )}
                        </div>

                        <div className="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                            <Link
                                href={route('tasks.index')}
                                className="flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors font-medium"
                            >
                                <X className="h-4 w-4 mr-2" />
                                Cancelar
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="flex items-center bg-gray-900 text-white px-8 py-4 rounded-xl font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 transform hover:scale-105"
                            >
                                <Save className="h-4 w-4 mr-2" />
                                {processing ? 'Salvando...' : 'Salvar'}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
} 