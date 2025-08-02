import React from 'react';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import TaskForm from '@/Components/Tasks/TaskForm';

export default function Create({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="text-xl font-semibold text-gray-900">Nova Tarefa</h2>}
        >
            <Head title="Nova Tarefa" />

            <TaskForm mode="create" />
        </AuthenticatedLayout>
    );
} 