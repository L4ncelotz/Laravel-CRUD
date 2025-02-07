import { useState } from 'react';
import { Link } from '@inertiajs/react';

export default function Navigation() {
    const [isOpen, setIsOpen] = useState(false);

    return (
        <nav className="fixed top-4 right-4 z-50">
            {/* Hamburger Button */}
            <button 
                onClick={() => setIsOpen(!isOpen)} 
                className="bg-gray-800 text-white p-3 rounded-lg shadow-lg hover:bg-gray-700 transition-colors"
            >
                <svg 
                    className="w-6 h-6" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path 
                        className={isOpen ? 'hidden' : 'inline-flex'} 
                        strokeLinecap="round" 
                        strokeLinejoin="round" 
                        strokeWidth="2" 
                        d="M4 6h16M4 12h16M4 18h16" 
                    />
                    <path 
                        className={!isOpen ? 'hidden' : 'inline-flex'} 
                        strokeLinecap="round" 
                        strokeLinejoin="round" 
                        strokeWidth="2" 
                        d="M6 18L18 6M6 6l12 12" 
                    />
                </svg>
            </button>

            {/* Dropdown Menu */}
            <div 
                className={`${
                    isOpen ? 'block' : 'hidden'
                } absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2`}
            >
                <Link 
                    href={route('products.index')} 
                    className="block px-4 py-2 text-gray-800 hover:bg-gray-100"
                >
                    Products
                </Link>
                <Link 
                    href={route('bookings.index')} 
                    className="block px-4 py-2 text-gray-800 hover:bg-gray-100"
                >
                    Bookings
                </Link>
                <Link 
                    href={route('reg.index')} 
                    className="block px-4 py-2 text-gray-800 hover:bg-gray-100"
                >
                    Registration
                </Link>
            </div>
        </nav>
    );
} 