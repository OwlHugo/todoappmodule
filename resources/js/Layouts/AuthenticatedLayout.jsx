import { useState } from 'react';
import { Link } from '@inertiajs/react';
import { Menu, X, CheckSquare, LogOut } from 'lucide-react';

export default function AuthenticatedLayout({ user, header, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    return (
        <div className="min-h-screen bg-white">
            <nav className="border-b border-gray-100 bg-white/80 backdrop-blur-sm sticky top-0 z-50">
                <div className="max-w-5xl mx-auto px-6">
                    <div className="flex justify-between h-16">
                        <div className="flex items-center">
                            <Link href={route('tasks.index')} className="text-xl font-semibold text-gray-900 hover:text-gray-700 transition-colors">
                                Todo
                            </Link>
                        </div>

                        <div className="hidden sm:flex sm:items-center sm:ml-6">
                            <div className="flex items-center space-x-8">
                                <Link
                                    href={route('tasks.index')}
                                    className="text-sm text-gray-600 hover:text-gray-900 transition-colors font-medium"
                                >
                                    Tarefas
                                </Link>
                            </div>

                            <div className="ml-8 flex items-center space-x-4">
                                <div className="flex items-center space-x-3">
                                    <span className="text-sm text-gray-600 font-medium">{user.name}</span>
                                    <Link
                                        href={route('logout')}
                                        method="post"
                                        as="button"
                                        className="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-lg hover:bg-gray-100"
                                    >
                                        <LogOut className="h-4 w-4" />
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div className="flex items-center sm:hidden">
                            <button
                                onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
                                className="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-colors"
                            >
                                {showingNavigationDropdown ? (
                                    <X className="h-6 w-6" />
                                ) : (
                                    <Menu className="h-6 w-6" />
                                )}
                            </button>
                        </div>
                    </div>
                </div>

                {showingNavigationDropdown && (
                    <div className="sm:hidden border-t border-gray-100 bg-white">
                        <div className="px-6 py-4 space-y-4">
                            <Link
                                href={route('tasks.index')}
                                className="block text-sm text-gray-600 hover:text-gray-900 transition-colors font-medium"
                            >
                                Tarefas
                            </Link>
                            <div className="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span className="text-sm text-gray-600 font-medium">{user.name}</span>
                                <Link
                                    href={route('logout')}
                                    method="post"
                                    as="button"
                                    className="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-lg hover:bg-gray-100"
                                >
                                    <LogOut className="h-4 w-4" />
                                </Link>
                            </div>
                        </div>
                    </div>
                )}
            </nav>

            {header && (
                <header className="border-b border-gray-100 bg-white">
                    <div className="max-w-5xl mx-auto px-6 py-8">
                        {header}
                    </div>
                </header>
            )}

            <main className="max-w-5xl mx-auto px-6 py-12">
                {children}
            </main>
        </div>
    );
}
