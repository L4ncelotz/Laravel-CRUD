import Navigation from '@/Components/Navigation';

export default function AppLayout({ children }) {
    return (
        <div>
            <Navigation />
            <main className="container mx-auto px-4 py-8">
                {children}
            </main>
        </div>
    );
} 