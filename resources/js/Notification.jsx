import React from "react";
import toast from "react-hot-toast";
import {CheckCircleIcon, XCircleIcon} from "@heroicons/react/24/outline";

export function notifySuccess(message) {
    toast.custom((t) => (
        <div className={`flex flex-row gap-2 items-center bg-gray-900 text-green-400 px-6 py-4 shadow-lg rounded-2xl text-lg ${
            t.visible ? 'animate-enter' : 'animate-leave'
        }`}>
            {message}
            <CheckCircleIcon className="w- h-6 text-green-400 text-2xl"/>
        </div>
    ));
}

export function notifyError(message) {
    toast.custom((t) => (
        <div className={`flex flex-row gap-2 items-center bg-gray-900 text-red-400 px-6 py-4 shadow-lg rounded-2xl text-lg ${
            t.visible ? 'animate-enter' : 'animate-leave'
        }`}>
            {message}
            <XCircleIcon className="w- h-6 text-red-400 text-2xl"/>
        </div>
    ));
}
