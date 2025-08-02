import { Alert } from "@/components/ui/alert";

export default function InputError({ message, className = '', ...props }) {
    return message ? (
        <Alert variant="destructive" {...props} className={className}>
            {message}
        </Alert>
    ) : null;
}
