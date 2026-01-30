interface Props {
    clicks: number,
    visible: boolean
    close: () => void
}

export function Stats({ clicks, close, visible }: Props) {
    return (
        <div
            style={{
                pointerEvents: visible ? 'auto' : 'none',
                opacity: visible ? '1' : '0'
            }}
            className="z-50 transition top-0 left-0 fixed w-screen h-screen flex justify-center items-center bg-black/20"
        >
            <div className="bg-white py-3 px-8 border-1 flex flex-col justify-center items-center gap-3">
                <p className="text-xl font-medium">Ilość kliknięć: <b>{ clicks }</b></p>
                <button onClick={close} className="btn btn-active">Zamknij</button>
            </div>
        </div>
    )
}
