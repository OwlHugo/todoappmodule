import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import TaskCard from '@/Components/Tasks/TaskCard';
import { Plus, Filter, X, Calendar } from 'lucide-react';

export default function Index({ auth, tasks, filters }) {
    const { data, setData, get } = useForm({
        status: filters.status || 'all',
        due_date: filters.due_date || '',
    });

    const currentStatus = data.status || 'all';

    const taskList = Array.isArray(tasks) ? tasks : (tasks && Array.isArray(tasks.data) ? tasks.data : []);

    const handleFilter = () => {
        // Processa a data para garantir formato correto
        let dueDate = data.due_date;
        if (dueDate) {
            // Garante que a data está no formato Y-m-d
            const date = new Date(dueDate);
            if (!isNaN(date.getTime())) {
                dueDate = date.toISOString().split('T')[0];
            }
        }
        
        const params = {
            status: data.status === 'all' ? '' : data.status,
            due_date: dueDate || ''
        };
        
        console.log('Enviando filtros:', params);
        
        get(route('tasks.index'), {
            data: params,
            preserveState: true,
            preserveScroll: true,
        });
    };

    const clearFilters = () => {
        setData({
            status: 'all',
            due_date: '',
        });
        get(route('tasks.index'), {
            data: {
                status: '',
                due_date: ''
            },
            preserveState: true,
            preserveScroll: true,
        });
    };

    const hasActiveFilters = (data.status && data.status !== 'all') || data.due_date;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-2xl font-bold text-gray-900">Tarefas</h2>
                    <Link
                        href={route('tasks.create')}
                        className="bg-gray-900 text-white px-6 py-3 rounded-xl text-sm font-medium hover:bg-gray-800 transition-all duration-200 transform hover:scale-105"
                    >
                        <Plus className="h-4 w-4 inline mr-2" />
                        Nova Tarefa
                    </Link>
                </div>
            }
        >
            <Head title="Tarefas" />

            <div className="mb-10 p-8 bg-gray-50 rounded-2xl">
                <div className="flex items-center justify-between mb-6">
                    <h3 className="text-lg font-semibold text-gray-900 flex items-center">
                        <Filter className="h-5 w-5 mr-3" />
                        Filtros
                    </h3>
                    {hasActiveFilters && (
                        <button
                            onClick={clearFilters}
                            className="text-sm text-gray-600 hover:text-gray-900 transition-colors p-2 rounded-lg hover:bg-gray-200"
                        >
                            <X className="h-4 w-4" />
                        </button>
                    )}
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label htmlFor="status" className="block text-sm font-medium text-gray-700 mb-3">
                            Status
                        </label>
                        <select
                            id="status"
                            value={currentStatus}
                            onChange={(e) => setData('status', e.target.value)}
                            className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-200"
                        >
                            <option value="all">Todos</option>
                            <option value="open">Aberta</option>
                            <option value="done">Concluída</option>
                        </select>
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
                            className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all duration-200"
                            placeholder="Selecione uma data"
                        />
                    </div>
                </div>

                <div className="mt-6">
                    <button
                        onClick={handleFilter}
                        className="bg-gray-900 text-white px-6 py-3 rounded-xl text-sm font-medium hover:bg-gray-800 transition-all duration-200 transform hover:scale-105"
                    >
                        Filtrar
                    </button>
                </div>
            </div>

            {taskList.length === 0 ? (
                <div className="text-center py-20">
                    <Calendar className="h-16 w-16 text-gray-400 mx-auto mb-6" />
                    <h3 className="text-2xl font-bold text-gray-900 mb-4">Nenhuma tarefa encontrada</h3>
                    <p className="text-lg text-gray-600 mb-8 max-w-md mx-auto">
                        {hasActiveFilters 
                            ? 'Tente ajustar os filtros ou criar uma nova tarefa.'
                            : 'Comece criando sua primeira tarefa.'
                        }
                    </p>
                    <Link
                        href={route('tasks.create')}
                        className="bg-gray-900 text-white px-8 py-4 rounded-xl text-lg font-medium hover:bg-gray-800 transition-all duration-200 transform hover:scale-105"
                    >
                        <Plus className="h-5 w-5 inline mr-2" />
                        Criar Tarefa
                    </Link>
                </div>
            ) : (
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {taskList.map((task) => (
                        <TaskCard key={task.id} task={task} />
                    ))}
                </div>
            )}
        </AuthenticatedLayout>
    );
} 