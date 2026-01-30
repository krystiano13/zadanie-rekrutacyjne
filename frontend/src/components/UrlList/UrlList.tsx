import { useState, useEffect } from "react";
import {Spinner} from "../Spinner/Spinner.tsx";

interface Link {
    code: string,
    url: string,
    alias: string|null,
}

export function UrlList() {
    const [filter, setFilter] = useState('private');
    const [links, setLinks] = useState<Link[]>([]);
    const [isFetching, setIsFetching] = useState<boolean>(false);
    const [fetchErrors, setFetchErrors] = useState<string[]>([]);

    async function handleCreate(e: FormDataEvent) {
        setIsFetching(true);
        e.preventDefault();

        const data = new FormData(e.target);

        if (data.get("expireTime") === 'none') {
            data.delete('expireTime');
        }

        await fetch('https://localhost/api/urls', {
            method: "POST",
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
            body: data
        })
            .then(res => res.json())
            .then(result => {
                if (result.error) {
                    setFetchErrors([result.error]);
                } else {
                    setFilter('private');
                }
            })
            .finally(() => setIsFetching(false))
    }

    async function loadPublic() {
        setIsFetching(true);
        await fetch('https://localhost/api/public', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
            .then(res => res.json())
            .then(data => {
                if(data.urls) {
                    setLinks([]);
                    setLinks(data.urls)
                }
            })
            .finally(() => setIsFetching(false))
    }

    async function loadPrivate() {
        setIsFetching(true);
        await fetch('https://localhost/api/urls', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
            .then(res => res.json())
            .then(data => {
                if(data.urls) {
                    setLinks([]);
                    setLinks(data.urls)
                }
            })
            .finally(() => setIsFetching(false))
    }

    useEffect(() => {
        if (filter === 'public') {
            loadPublic();
        }

        if (filter === 'private') {
            loadPrivate();
        }
    }, [filter])

    useEffect(() => {
        loadPrivate();
    }, []);

    return (
        <div className="w-screen h-screen flex flex-col items-start px-8 sm:px-48 pb-12 lg:px-64">
            <h1 className="font-medium text-4xl pt-24">
                URL Shortener
            </h1>

            <div className="pb-8">
                <button
                    onClick={() => setFilter('public')}
                    className={`btn ${filter === 'public' ? 'btn-active' : ''}`}
                >
                    Public links
                </button>
                <button
                    onClick={() => setFilter('private')}
                    className={`btn ${filter === 'private' ? 'btn-active' : ''}`}
                >
                    Your links
                </button>
                <button
                    onClick={() => setFilter('create')}
                    className={`btn ${filter === 'create' ? 'btn-active' : ''}`}
                >
                    Create link
                </button>
            </div>

            {
                filter !== 'create' &&
                <div className="w-full h-auto flex-1 relative overflow-y-auto border-1">
                    <Spinner visible={isFetching} />
                    {
                        links.map(item => (
                            <div className="flex justify-between p-2 border-b-1">
                                <div className="flex items-center gap-1">
                                    <label>{ item.url }</label>
                                    <label>kod: { item.code }</label>
                                    <label>{ item.alias ? item.alias : '(brak aliasu)' }</label>
                                </div>
                                <div className="flex items-center">
                                    <button
                                        onClick={() => {
                                            navigator.clipboard.writeText(`https://localhost/${item.alias ? item.alias : item.code}`)
                                            alert('Skopiowano do schowka')
                                        }}
                                        className="btn btn-active mt-0!"
                                    >
                                        Copy
                                    </button>
                                    <button className="btn btn-active mt-0!">Stats</button>
                                    {
                                        filter === 'private' &&
                                        <button className="btn btn-active mt-0!">Delete</button>
                                    }
                                </div>
                            </div>
                        ))
                    }
                </div>
            }

            {
                filter === 'create' &&
                <form onSubmit={handleCreate} className="flex w-100 flex-col gap-2 items-start">
                    {
                        fetchErrors.map((error: string) => (
                            <p className="p-2 my-2 border border-red-500 text-red-500 bg-red-200">
                                { error }
                            </p>
                        ))
                    }

                    <input name="url" className="w-full" placeholder="URL" required />

                    <div className="w-full">
                        <label>Visibility:</label>
                        <br />
                        <select name="type" className="w-full">
                            <option value="private">Private</option>
                            <option value="public">Public</option>
                        </select>
                    </div>

                    <div className="w-full">
                        <label>Expiration Time:</label>
                        <br />
                        <select name="expireTime" className="w-full">
                            <option value="none">None</option>
                            <option value="1h">1 hour</option>
                            <option value="1d">1 day</option>
                            <option value="1t">1 week</option>
                        </select>
                    </div>

                    <input name="alias" className="w-full" placeholder="Alias" />

                    <button disabled={isFetching} className="btn btn-active">Create</button>
                </form>
            }
        </div>
    )
}
