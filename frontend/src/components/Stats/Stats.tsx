import { useEffect, useState} from "react";

interface Props {
    linkId: number,
    visible: boolean
    close: () => void
}

export function Stats({ linkId, close, visible }: Props) {
    const [clicks, setClicks] = useState<number>(0);
    const [isFetching, setIsFetching] = useState<boolean>(false);

    async function getStats() {
        setIsFetching(true);
        await fetch(`https://localhost/api/urls/${linkId}/stats`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.clicks || data.clicks === 0) {
                    setClicks(data.clicks)
                }
            })
            .finally(() => setIsFetching(false));
    }

    useEffect(() => {
        if (visible) {
            getStats();
        }
    }, [visible]);

    return (
        <div
            style={{
                pointerEvents: visible ? 'auto' : 'none',
                opacity: visible ? '1' : '0'
            }}
            className="z-50 transition top-0 left-0 fixed w-screen h-screen flex justify-center items-center bg-black/20"
        >
            <div className="bg-white py-3 px-8 w-80 border-1 flex flex-col justify-center items-center gap-3">
                <p className="text-xl font-medium">Clicks: <b>{ !isFetching ? clicks : "Loading ..." }</b></p>
                <button onClick={close} className="btn btn-active">Close</button>
            </div>
        </div>
    )
}
