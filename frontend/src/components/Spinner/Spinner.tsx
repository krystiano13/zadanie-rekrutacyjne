import "./Spinner.css";

interface Props {
    visible: boolean
}

export function Spinner({ visible }: Props) {
    return (
        <div className={`w-full absolute pointer-events-none h-full flex justify-center items-center bg-white transition ${!visible ? 'opacity-0' : 'opacity-100'}`}>
            <span className="loader"></span>
        </div>
    )
}
