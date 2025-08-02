import React from 'react';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import TaskForm from '@/Components/Tasks/TaskForm';

export default function Edit({ auth, task }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="text-xl font-semibold text-gray-900">Editar Tarefa</h2>}
        >
            <Head title="Editar Tarefa" />

            <TaskForm task={task} mode="edit" />
        </AuthenticatedLayout>
    );
} 