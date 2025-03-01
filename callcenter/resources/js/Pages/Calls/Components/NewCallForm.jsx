import { useForm } from '@inertiajs/react';

export default function NewCallForm() {
    const { data, setData, post, processing, errors, reset } = useForm({
        caller_number: '',
        call_type: 'incoming',
        notes: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('index.store'), {
            onSuccess: () => reset()
        });
    };

    return (
        <form onSubmit={handleSubmit} className="mb-8">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Caller Number
                    </label>
                    <input
                        type="text"
                        value={data.caller_number}
                        onChange={e => setData('caller_number', e.target.value)}
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        required
                    />
                    {errors.caller_number && (
                        <div className="text-red-500 text-sm mt-1">{errors.caller_number}</div>
                    )}
                </div>

                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Call Type
                    </label>
                    <select
                        value={data.call_type}
                        onChange={e => setData('call_type', e.target.value)}
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                        <option value="incoming">Incoming</option>
                        <option value="outgoing">Outgoing</option>
                    </select>
                </div>

                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Notes
                    </label>
                    <textarea
                        value={data.notes}
                        onChange={e => setData('notes', e.target.value)}
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    />
                </div>
            </div>

            <div className="mt-4">
                <button
                    type="submit"
                    disabled={processing}
                    className="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 disabled:opacity-50"
                >
                    Log New Call
                </button>
            </div>
        </form>
    );
}
