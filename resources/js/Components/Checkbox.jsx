import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function Checkbox(
    { type = 'checkbox', className = '', ...props },
    ref
) {
    const input = ref ? ref : useRef();

    useEffect(() => {
        if (input.current) {
            input.current.indeterminate = props.indeterminate;
        }
    }, [props.indeterminate]);

    return (
        <input
            {...props}
            type={type}
            className={
                'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 ' +
                className
            }
            ref={input}
        />
    );
}); 