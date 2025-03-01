
import React from 'react';
import {useState } from "react";
import {useForm} from "@inertiajs/react";

export default function CallActions(){
    const [isCallModalOpen , setIsCallModalOpen] = useState(false);
    const[isMessageModalOpen , setIsMessageModalOpen] = useState(false);

    const callForm = useForm({
        'phone_number': '',
        'message': '',
    });

    const messageForm = useForm({
        'phone_number': '',
        'message': '',
    });


    const initiateCall = (e)=>{
        e.preventDefault();
        callForm.post(route('calls.initiate'), {
            onSuccess: () => {
                setIsCallModalOpen(false);
                callForm.reset();
            },
        });
    }

    const sendMessage = (e)=>{
        e.preventDefault();
        messageForm.post(route('calls.message'), {
            onSuccess: () => {
                setIsMessageModalOpen(false);
                messageForm.reset();
            },
        });
    }

    return (
        <div className={"mb-5"}>
            <div className={"flex space-x-4"}>
                <button className={"bg-blue-500 text-white px-4 py-2 rounded-md"} onClick={()=>setIsCallModalOpen(true)}>Make Call</button>
                <button className={"bg-blue-500 text-white px-4 py-2 rounded-md"} onClick={()=>setIsMessageModalOpen(true)}>Send Message</button>
            </div>

            {isCallModalOpen && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                    <div className="bg-white rounded-lg p-6 max-w-md w-full">
                        <h3 className="text-lg font-medium mb-4">Make a Call</h3>
                        <form onSubmit={initiateCall}>
                            <div className="mb-4">
                                <label className="block text-sm font-medium mb-1">Phone Number</label>
                                <input
                                    type="text"
                                    value={callForm.data.phone_number}
                                    onChange={e => callForm.setData('phone_number', e.target.value)}
                                    className="w-full p-2 border rounded"
                                    placeholder="+1234567890"
                                />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium mb-1">Message to Say</label>
                                <textarea
                                    value={callForm.data.message}
                                    onChange={e => callForm.setData('message', e.target.value)}
                                    className="w-full p-2 border rounded"
                                    rows="3"
                                    placeholder="Enter message to be spoken..."
                                />
                            </div>
                            <div className="flex justify-end space-x-2">
                                <button
                                    type="button"
                                    onClick={() => setIsCallModalOpen(false)}
                                    className="px-4 py-2 border rounded"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={callForm.processing}
                                    className="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                >
                                    Make Call
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )

            }


            {isMessageModalOpen && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                    <div className="bg-white rounded-lg p-6 max-w-md w-full">
                        <h3 className="text-lg font-medium mb-4">Send Message</h3>
                        <form onSubmit={sendMessage}>
                            <div className="mb-4">
                                <label className="block text-sm font-medium mb-1">Phone Number</label>
                                <input
                                    type="text"
                                    value={messageForm.data.phone_number}
                                    onChange={e => messageForm.setData('phone_number', e.target.value)}
                                    className="w-full p-2 border rounded"
                                    placeholder="+1234567890"
                                />
                            </div>
                            <div className="mb-4">
                                <label className="block text-sm font-medium mb-1">Message</label>
                                <textarea
                                    value={messageForm.data.message}
                                    onChange={e => messageForm.setData('message', e.target.value)}
                                    className="w-full p-2 border rounded"
                                    rows="3"
                                    placeholder="Enter message to send..."
                                />
                            </div>
                            <div className="flex justify-end space-x-2">
                                <button
                                    type="button"
                                    onClick={() => setIsMessageModalOpen(false)}
                                    className="px-4 py-2 border rounded"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={messageForm.processing}
                                    className="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                                >
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

        </div>
    );
}
