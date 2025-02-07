import { useState, useEffect } from 'react';
import { Link } from '@inertiajs/react';

export default function HamburgerMenu() {
    const [isOpen, setIsOpen] = useState(false);

    // ปิดเมนูเมื่อคลิกนอกเมนู
    useEffect(() => {
        const closeMenu = (e) => {
            if (isOpen && !e.target.closest('.menu-container')) {
                setIsOpen(false);
            }
        };
        document.addEventListener('click', closeMenu);
        return () => document.removeEventListener('click', closeMenu);
    }, [isOpen]);

    return (
        <div className="menu-container fixed top-4 right-4 z-50">
            {/* Hamburger Button */}
            <button 
                onClick={(e) => {
                    e.stopPropagation();
                    setIsOpen(!isOpen);
                }}
                className="bg-indigo-600 text-white p-3 rounded-lg shadow-lg hover:bg-indigo-700 transition-colors"
            >
                <svg 
                    className="w-6 h-6" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path 
                        strokeLinecap="round" 
                        strokeLinejoin="round" 
                        strokeWidth="2" 
                        d={isOpen ? "M6 18L18 6M6 6l12 12" : "M4 6h16M4 12h16M4 18h16"}
                    />
                </svg>
            </button>

            {/* Dropdown Menu */}
            {isOpen && (
                <div className="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 border border-gray-100">
                    <Link 
                        href={route('products.index')} 
                        className="block px-4 py-2 text-gray-800 hover:bg-indigo-50"
                    >
                        สินค้า
                    </Link>
                    <Link 
                        href={route('bookings.index')} 
                        className="block px-4 py-2 text-gray-800 hover:bg-indigo-50"
                    >
                        จองห้องพัก
                    </Link>
                    <Link 
                        href={route('reg.index')} 
                        className="block px-4 py-2 text-gray-800 hover:bg-indigo-50"
                    >
                        ลงทะเบียนเรียน
                    </Link>
                </div>
            )}
        </div>
    );
} 