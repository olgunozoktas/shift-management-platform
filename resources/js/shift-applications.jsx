import './bootstrap';
import React, {useEffect, useState} from "react";
import {createRoot} from "react-dom/client";
import {Toaster} from "react-hot-toast";
import {notifyError, notifySuccess} from "./Notification";
import Pagination from "./pagination";

export default function ShiftApplications() {
    const [companies, setCompanies] = useState([]);
    const [applications, setApplications] = useState([]);

    useEffect(() => {
        loadCompanies();
    }, []);

    function loadCompanies() {
        axios.get('/my-companies').then((res) => {
            setCompanies(res.data);
            loadShiftApplications(res.data[0].id);
        }).catch((error) => {
            console.log(error);
        })
    }

    function loadShiftApplications(companyId) {
        axios.get('/shift-applications/' + companyId).then((res) => {
            setApplications(res.data);
        }).catch((error) => {
            console.log(error);
        })
    }

    function loadShiftApplicationsFromPagination(url = null) {
        if (url == null) {
            return;
        }

        axios.get(url).then((res) => {
            setApplications(res.data);
        }).catch((error) => {
            console.log(error);
        })
    }

    const onChangeHandler = (companyId) => {
        loadShiftApplications(companyId);
    }

    const applyShift = (shiftId) => {
        const currentAvailableShifts = [...applications.data];
        const findIndex = currentAvailableShifts.findIndex((shift) => shift.id === shiftId);

        if (currentAvailableShifts[findIndex].submitted === true) {
            notifyError("Application is still processing...")
            return;
        }

        currentAvailableShifts[findIndex].submitted = true;
        const data = applications;
        data.data = currentAvailableShifts;
        setApplications(data);

        if (confirm('Do you want to apply to this shift?')) {
            axios.post('/available-shifts/' + shiftId + '/apply').then((res) => {
                if (res.data.status === 'success') {
                    notifySuccess(res.data.message);
                    loadShiftApplications(selectedCompanyId);
                } else {
                    notifyError(res.data.message);
                }

                currentAvailableShifts[findIndex].submitted = false;
                data.data = currentAvailableShifts;
                setApplications(data);
            }).catch((error) => {
                console.log(error);
                currentAvailableShifts[findIndex].submitted = false;
                data.data = currentAvailableShifts;
                setApplications(data);
            })
        }
    }

    return <>

        <Toaster
            position="top-right"
            reverseOrder={false}
            gutter={8}
            containerClassName=""
            containerStyle={{}}
        />

        <section className="relative overflow-x-auto mt-4">
            {companies.length > 0 ? <div className="flex flex-col gap-2 w-max">
                <label htmlFor="company">Select Company To List Available Shifts</label>
                <select name="company" id="company" onChange={(event) => onChangeHandler(event.target.value)}
                        className="rounded-lg cursor-pointer">
                    {companies.map((company) => <option key={company.id} value={company.id}>{company.name}</option>)}
                </select>
            </div> : null}

            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-6 shadow-md sm:rounded-lg"
                   id="table">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr className="text-center bg-gray-100">
                    <th scope="col" className="px-6 py-3">User</th>
                    <th scope="col" className="px-6 py-3">Job Role</th>
                    <th scope="col" className="px-6 py-3">Type</th>
                    <th scope="col" className="px-6 py-3">Date</th>
                    <th scope="col" className="px-6 py-3">Description</th>
                    <th scope="col" className="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                {applications?.data?.length > 0 ? applications.data.map((application) => <tr key={application.id}
                                                                                             className="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" className="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {application.user.name}
                        </th>
                        <td className="py-2">{application.shift.job_role.definition}</td>
                        <td className="py-2">{application.shift.type}</td>
                        <td className="py-2">{application.shift.date_time}</td>
                        <td className="py-2">{application.shift.text ?? '-'}</td>
                        <td className="flex flex-row items-center justify-center gap-2 py-2">
                            <a href={"/shift-applications/" + application.id + '/details'}
                               className="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">View Details
                            </a>
                        </td>
                    </tr>) :
                    <tr className="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colSpan="5" className="py-4">No Available Shifts Found For Selected Company</td>
                    </tr>
                }
                </tbody>
            </table>
            <Pagination data={applications} clickHandler={loadShiftApplicationsFromPagination}/>
        </section>
    </>
}

let app = document.getElementById('shift-applications');
if (app) {
    const root = createRoot(app);
    root.render(<ShiftApplications/>);
}
