import React from 'react';
import { useForm } from '@inertiajs/react';

export default function CallsList({ calls }) {
    // Default to empty array if calls or calls.data is undefined
    const callsData = calls?.data || [];

    const updateCall = (callId, status) => {
        const form = useForm({
            status: status,
            duration: Math.floor(Math.random() * 300) + 60
        });

        form.put(route('calls.update', callId));
    };

    if (callsData.length === 0) {
        return (
            <div className="mt-6">
                <h3 className="text-lg font-medium text-gray-900">Recent Calls</h3>
                <div className="mt-4 text-gray-500">No calls found.</div>
            </div>
        );
    }

    return (
        <div className="mt-6">
            <h3 className="text-lg font-medium text-gray-900">Recent Calls</h3>
            <div className="mt-4">
                <div className="overflow-x-auto">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Caller
                            </th>
                            <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration
                            </th>
                            <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                        {callsData.map((call) => (
                            <tr key={call.id}>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    {call.caller_number}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    {call.call_type}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                        <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            ${call.status === 'completed' ? 'bg-green-100 text-green-800' : ''}
                                            ${call.status === 'in-progress' ? 'bg-yellow-100 text-yellow-800' : ''}
                                            ${call.status === 'missed' ? 'bg-red-100 text-red-800' : ''}
                                            ${call.status === 'queued' ? 'bg-blue-100 text-blue-800' : ''}
                                        `}>
                                            {call.status}
                                        </span>
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    {call.duration || '-'}s
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {call.status !== 'completed' && (
                                        <button
                                            onClick={() => updateCall(call.id, 'completed')}
                                            className="text-indigo-600 hover:text-indigo-900"
                                        >
                                            Complete
                                        </button>
                                    )}
                                </td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}
