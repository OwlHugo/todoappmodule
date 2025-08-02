import { Button } from "@/components/ui/button";

export default function PrimaryButton({ className = '', disabled, children, ...props }) {
    return (
        <Button
            {...props}
            className={className}
            disabled={disabled}
        >
            {children}
        </Button>
    );
}
