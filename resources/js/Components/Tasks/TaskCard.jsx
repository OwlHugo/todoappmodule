import { Link } from '@inertiajs/react';
import { Edit, Trash2, Calendar, CheckCircle, Clock } from 'lucide-react';

export default function TaskCard({ task }) {
    console.log('TaskCard data:', task);
    const isOverdue = (() => {
        if (!task.due_date || task.status?.value === 'done' || task.status === 'done') {
            return false;
        }
        try {
            const dueDate = new Date(task.due_date);
            const now = new Date();
            return !isNaN(dueDate.getTime()) && dueDate < now;
        } catch (error) {
            return false;
        }
    })();
    const isCompleted = task.status?.value === 'done' || task.status === 'done';

    return (
        <div className={`p-8 border border-gray-200 rounded-2xl hover:border-gray-300 transition-all duration-200 hover:shadow-lg ${
            isCompleted ? 'bg-gray-50' : 'bg-white'
        }`}>
            <div className="flex items-start justify-between mb-6">
                <div className="flex-1">
                    <h3 className={`text-lg font-semibold text-gray-900 mb-3 ${
                        isCompleted ? 'text-gray-500' : ''
                    }`}>
                        {task.title}
                    </h3>
                    <p className={`text-gray-600 mb-4 leading-relaxed ${
                        isCompleted ? 'text-gray-400' : ''
                    }`}>
                        {task.description}
                    </p>
                </div>
                
                <div className="flex items-center space-x-3 ml-6">
                    <Link
                        href={route('tasks.edit', task.id)}
                        className="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-lg hover:bg-gray-100"
                    >
                        <Edit className="h-4 w-4" />
                    </Link>
                    <Link
                        href={route('tasks.destroy', task.id)}
                        method="delete"
                        as="button"
                        className="text-gray-400 hover:text-red-600 transition-colors p-2 rounded-lg hover:bg-red-50"
                    >
                        <Trash2 className="h-4 w-4" />
                    </Link>
                </div>
            </div>

            <div className="flex items-center justify-between">
                <div className="flex items-center space-x-6">
                    {task.due_date && (
                        <div className="flex items-center text-sm text-gray-600">
                            <Calendar className="h-4 w-4 mr-2" />
                            {task.due_date_formatted || task.due_date}
                        </div>
                    )}
                    
                    <div className="flex items-center">
                        {isCompleted ? (
                            <span className="inline-flex items-center text-sm text-green-600 font-medium">
                                <CheckCircle className="h-4 w-4 mr-2" />
                                Concluída
                            </span>
                        ) : (
                            <span className="inline-flex items-center text-sm text-gray-600 font-medium">
                                <Clock className="h-4 w-4 mr-2" />
                                Aberta
                            </span>
                        )}
                    </div>
                </div>

                {isOverdue && (
                    <span className="text-sm text-red-600 font-semibold bg-red-50 px-3 py-1 rounded-lg">
                        Vencida
                    </span>
                )}
            </div>
        </div>
    );
} 