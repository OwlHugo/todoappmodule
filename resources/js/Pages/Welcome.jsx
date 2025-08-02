import { Head, Link } from '@inertiajs/react';

export default function Welcome({ auth }) {
    return (
        <>
            <Head title="Todo" />
            
            <div className="min-h-screen bg-white">
                <header className="border-b border-gray-100">
                    <div className="max-w-5xl mx-auto px-6 py-4">
                        <div className="flex justify-between items-center">
                            <div className="flex items-center">
                                <h1 className="text-xl font-semibold text-gray-900">
                                    Todo
                                </h1>
                            </div>
                            <nav className="flex items-center space-x-6">
                                {auth.user ? (
                                    <Link
                                        href={route('tasks.index')}
                                        className="text-sm text-gray-600 hover:text-gray-900 transition-colors"
                                    >
                                        Tarefas
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="text-sm text-gray-600 hover:text-gray-900 transition-colors"
                                        >
                                            Entrar
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-all duration-200"
                                        >
                                            Cadastrar
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                <main className="max-w-5xl mx-auto px-6 py-24">
                    <div className="text-center">
                        <h2 className="text-6xl font-bold text-gray-900 mb-8 leading-tight">
                            Organize suas tarefas
                            <br />
                            <span className="text-gray-600">com simplicidade</span>
                        </h2>
                        <p className="text-xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                            Uma aplicação minimalista e eficiente para gerenciar suas tarefas diárias. 
                            Foque no que importa, sem distrações.
                        </p>
                        <div className="flex justify-center">
                            {auth.user ? (
                                <Link
                                    href={route('tasks.index')}
                                    className="bg-gray-900 text-white px-8 py-4 rounded-lg text-lg font-medium hover:bg-gray-800 transition-all duration-200 transform hover:scale-105"
                                >
                                    Ver minhas tarefas
                                </Link>
                            ) : (
                                <Link
                                    href={route('register')}
                                    className="bg-gray-900 text-white px-8 py-4 rounded-lg text-lg font-medium hover:bg-gray-800 transition-all duration-200 transform hover:scale-105"
                                >
                                    Começar agora
                                </Link>
                            )}
                        </div>
                    </div>
                </main>

                <footer className="border-t border-gray-100 mt-24">
                    <div className="max-w-5xl mx-auto py-12 px-6">
                        <div className="text-center text-sm text-gray-500">
                            <p>&copy; 2025 Todo. Desenvolvido com Laravel, React e Inertia.js</p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
} 