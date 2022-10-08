import './bootstrap';
import React, {useEffect, useState} from "react";
import {createRoot} from "react-dom/client";
import {Toaster} from "react-hot-toast";
import {notifyError, notifySuccess} from "./Notification";
import Pagination from "./pagination";

export default function MySchedules() {
    const [companies, setCompanies] = useState([]);
    const [schedules, setSchedules] = useState([]);

    useEffect(() => {
        loadCompanies();
    }, []);

    function loadCompanies() {
        axios.get('/my-companies').then((res) => {
            setCompanies(res.data);
            loadSchedules(res.data[0].id);
        }).catch((error) => {
            console.log(error);
        })
    }

    function loadSchedules(companyId) {
        axios.get('/my-schedules/' + companyId).then((res) => {
            setSchedules(res.data);
        }).catch((error) => {
            console.log(error);
        })
    }

    function loadSchedulesFromPagination(url = null) {
        if(url == null) {
            return;
        }

        axios.get(url).then((res) => {
            setSchedules(res.data);
        }).catch((error) => {
            console.log(error);
        })
    }

    const onChangeHandler = (companyId) => {
        loadSchedules(companyId);
    }

    return <>
        <section className="relative overflow-x-auto mt-4">
            {companies.length > 0 ? <div className="flex flex-col gap-2 w-max">
                <label htmlFor="company">Select Company To List Schedules</label>
                <select name="company" id="company" onChange={(event) => onChangeHandler(event.target.value)}
                        className="rounded-lg cursor-pointer">
                    {companies.map((company) => <option key={company.id} value={company.id}>{company.name}</option>)}
                </select>
            </div> : null}

            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-6 shadow-md sm:rounded-lg" id="table">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr className="text-center bg-gray-100">
                    <th scope="col" className="px-6 py-3">Job Role</th>
                    <th scope="col" className="px-6 py-3">Schedule Type</th>
                    <th scope="col" className="px-6 py-3">Date</th>
                    <th scope="col" className="px-6 py-3">Description</th>
                </tr>
                </thead>
                <tbody>
                {schedules?.data?.length > 0 ? schedules.data.map((schedule) => <tr key={schedule.id}
                        className="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" className="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {schedule.job_role}
                        </th>
                        <td className="py-2">{schedule.type}</td>
                        <td className="py-2">{schedule.date_time}</td>
                        <td className="py-2">{schedule.text ?? '-'}</td>
                    </tr>) :
                    <tr className="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colSpan="5" className="py-4">No Schedules Found For Selected Company</td>
                    </tr>
                }
                </tbody>
            </table>
            <Pagination data={schedules} clickHandler={loadSchedulesFromPagination}/>
        </section>
    </>
}

let app = document.getElementById('my-schedules');
if (app) {
    const root = createRoot(app);
    root.render(<MySchedules/>);
}
