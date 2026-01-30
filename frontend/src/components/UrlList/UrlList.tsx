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

    useEffect(() => {
        if (filter === 'public') {
            loadPublic();
        }
    }, [filter])

    useEffect(() => {
        loadPublic();
    }, []);

    return (
        <div className="w-screen h-screen flex flex-col items-start px-8 sm:px-48 pb-12 lg:px-64">
            <h1 className="font-medium text-4xl pt-24">
                Skracacz linków
            </h1>

            <div className="pb-8">
                <button
                    onClick={() => setFilter('public')}
                    className={`btn ${filter === 'public' ? 'btn-active' : ''}`}
                >
                    Publiczne linki
                </button>
                <button
                    onClick={() => setFilter('private')}
                    className={`btn ${filter === 'private' ? 'btn-active' : ''}`}
                >
                    Twoje linki
                </button>
            </div>

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
                                <button className="btn btn-active mt-0!">Kopiuj</button>
                                <button className="btn btn-active mt-0!">Statystyki</button>
                                {
                                    filter === 'private' &&
                                    <button className="btn btn-active mt-0!">Usuń</button>
                                }
                            </div>
                        </div>
                    ))
                }
            </div>
        </div>
    )
}
