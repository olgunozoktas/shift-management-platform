import './bootstrap';
import React, {useEffect, useState} from "react";
import {createRoot} from "react-dom/client";
import {Toaster} from "react-hot-toast";
import {notifyError, notifySuccess} from "./Notification";
import Pagination from "./pagination";

export default function Shifts() {
    const [companies, setCompanies] = useState([]);
    const [shifts, setShifts] = useState([]);

    useEffect(() => {
        loadCompanies();
    }, []);

    function loadCompanies() {
        axios.get('/my-companies').then((res) => {
            setCompanies(res.data);
            loadShifts(res.data[0].id);
        }).catch((error) => {
            console.log(error);
        })
    }

    function loadShifts(companyId) {
        axios.get('/api/v1/shifts/' + companyId + '/list').then((res) => {
            setShifts(res.data);
        }).catch((error) => {
            console.log(error);
        })
    }

    function loadShiftsFromPagination(url = null) {
        if(url == null) {
            return;
        }

        axios.get(url).then((res) => {
            setShifts(res.data);
        }).catch((error) => {
            console.log(error);
        })
    }

    const onChangeHandler = (companyId) => {
        loadShifts(companyId);
    }

    return <>
        <section className="relative overflow-x-auto mt-4">
            {companies.length > 0 ? <div className="flex flex-col gap-2 w-max">
                <label htmlFor="company">Select Company To List Shifts</label>
                <select name="company" id="company" onChange={(companyId) => onChangeHandler(companyId)}
                        className="rounded-lg">
                    {companies.map((company) => <option key={company.id} value={company.id}>{company.name}</option>)}
                </select>
            </div> : null}

            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-6 shadow-md sm:rounded-lg" id="table">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr className="text-center bg-gray-100">
                    <th scope="col" className="px-6 py-3">Date & Time</th>
                    <th scope="col" className="px-6 py-3">Type</th>
                    <th scope="col" className="px-6 py-3">Job Role</th>
                    <th scope="col" className="px-6 py-3">Assigned User</th>
                    <th scope="col" className="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                {shifts?.data?.length > 0 ? shifts.data.map((shift) => <tr key={shift.id}
                        className="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" className="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {shift.date_time}
                        </th>
                        <td className="py-2">{shift.type}</td>
                        <td className="py-2">{shift.job_role.definition}</td>
                        <td className="py-2">{shift.assigned_user?.name ?? '-'}</td>
                        <td className="flex flex-row items-center justify-center gap-2 py-2">
                            <a href={"/shifts/" + (shift.id) + '/edit'}
                               className="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">Edit</a>
                        </td>
                    </tr>) :
                    <tr className="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colSpan="5" className="py-4">No Shifts Found In Your Company</td>
                    </tr>
                }
                </tbody>
            </table>
            <Pagination data={shifts} clickHandler={loadShiftsFromPagination}/>
        </section>
    </>
}

let app = document.getElementById('shifts');
if (app) {
    const root = createRoot(app);
    root.render(<Shifts/>);
}
