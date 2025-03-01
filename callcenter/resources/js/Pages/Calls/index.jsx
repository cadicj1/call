import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import { Head } from '@inertiajs/react';
import NewCallForm from './Components/NewCallForm.jsx';
import CallsList from './Components/CallsList.jsx';

export default function index({}){
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Calls Dashboard</h2>}
        >
         <Head title="Calls Center" />

            <div className={"py-12"}>
                <div className={"max-w-7xl mx-auto sm:px-6 lg:px-8"}>
                    <div className="p-6 bg-white border-b border-gray-200">
                        <NewCallForm />
                        <CallsList calls={index} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>

    );
}
