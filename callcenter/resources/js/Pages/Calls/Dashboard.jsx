import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import NewCallForm from './Components/NewCallForm';
import CallsList from './Components/CallsList';
import CallActions from './Components/CallActions';

export default function dashboard({ auth, calls }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Call Center Dashboard</h2>}
        >
            <Head title="Call Center" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">

                            <CallActions />
                            <NewCallForm />
                            <CallsList calls={calls} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
