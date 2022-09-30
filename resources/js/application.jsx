import './bootstrap';
import React, {useEffect, useState} from "react";
import {createRoot} from "react-dom/client";
import {Toaster} from "react-hot-toast";
import {notifyError, notifySuccess} from "./Notification";

export default function Application({applicationId}) {
    const [application, setApplication] = useState(null);
    const [documents, setDocuments] = useState([]);
    const [companies, setCompanies] = useState([]);
    const [jobRoles, setJobRoles] = useState([]);
    const [selectedCompany, setSelectedCompany] = useState(null);
    const [selectedJob, setSelectedJob] = useState(null);
    const [rejectReason, setRejectReason] = useState(null);
    const [phoneNo, setPhoneNo] = useState(null);
    const [companyPhoneNo, setCompanyPhoneNo] = useState(null);

    useEffect(() => {
        loadApplication();
        loadCompanies();
        loadJobRoles();
    }, []);

    function loadApplication() {
        axios.get('/application/' + applicationId + '/show').then((res) => {
            setApplication(res.data);

            let documents = res.data.user.user_documents;
            setDocuments(documents.filter((document) => (document.status === 'pending' || document.status === 'approved')));
        }).catch((error) => {
            console.log(error);
        })
    }

    function loadCompanies() {
        axios.get('/api/v1/companies').then((res) => {
            setCompanies(res.data);
            setSelectedCompany(res.data[0].id);
        }).catch((error) => {
            console.log(error);
        })
    }

    function loadJobRoles() {
        axios.get('/api/v1/job-roles').then((res) => {
            setJobRoles(res.data);
            setSelectedJob(res.data[0].id);
        }).catch((error) => {
            console.log(error);
        })
    }

    function approveDocument(id) {
        const currentDocuments = [...documents];
        const index = currentDocuments.findIndex((document) => document.id === id);
        currentDocuments[index].is_approved = true;
        currentDocuments[index].is_rejected = false;
        setDocuments(currentDocuments);
    }

    function rejectDocument(id) {
        const currentDocuments = [...documents];
        const index = currentDocuments.findIndex((document) => document.id === id);
        currentDocuments[index].is_rejected = true;
        currentDocuments[index].is_approved = false;
        setDocuments(currentDocuments);
    }

    const onChangeHandler = (event, id = null) => {
        if (event.target.name === 'reject') {
            const currentDocuments = [...documents];
            const index = currentDocuments.findIndex((document) => document.id === id);
            currentDocuments[index].reject_reason = event.target.value;
            setDocuments(currentDocuments);
        } else if (event.target.name === 'company') {
            setSelectedCompany(event.target.value);
        } else if (event.target.name === 'job-role') {
            setSelectedJob(event.target.value);
        } else if (event.target.name === 'reject-reason') {
            setRejectReason(event.target.value);
        }  else if (event.target.name === 'phone-no') {
            setPhoneNo(event.target.value);
        }  else if (event.target.name === 'company-phone-no') {
            setCompanyPhoneNo(event.target.value);
        }
    }

    function approveApplication() {
        let formData = {};
        formData.selected_company_id = selectedCompany;
        formData.selected_job_role_id = selectedJob;
        formData.phone_no = phoneNo;
        formData.company_phone_no = companyPhoneNo;

        axios.post('/application/' + applicationId + '/approve', formData).then((res) => {
            if (res.data.status === 'success') {
                // notifySuccess(res.data.message);
                // loadApplication();
                window.location = '/applications';
            } else {
                notifyError(res.data.message);
            }
        }).catch((error) => {
            console.log(error);
        })
    }

    function rejectApplication() {

        const rejectedDocuments = documents.filter((document) => document.is_rejected === true);
        const approvedDocuments = documents.filter((document) => document.is_approved === true);

        if ((rejectedDocuments.length + approvedDocuments.length) !== documents.length) {
            notifyError('All documents have to be processed (approved or rejected)');
            return;
        }

        if (rejectReason == null || rejectReason === '' || rejectReason.length === 0) {
            notifyError('Reject reason must be entered');
            return;
        }

        let formData = {};
        formData.rejected_documents = documents.filter((document) => document.is_rejected === true);
        formData.reject_reason = rejectReason;

        axios.post('/application/' + applicationId + '/reject', formData).then((res) => {
            if (res.data.status === 'success') {
                // notifySuccess(res.data.message);
                // loadApplication();
                window.location = '/applications';
            } else {
                notifyError(res.data.message);
            }
        }).catch((error) => {
            console.log(error);
        })
    }

    return <>
        <Toaster
            position="top-right"
            reverseOrder={true}
            gutter={8}
            containerClassName=""
            containerStyle={{}}
        />

        {application?.status === 'pending' ? <div className="flex flex-col gap-2">
            <h1 className="text-lg text-black font-black my-4">In order to approve the application first of all you have
                to approve all uploaded documents.</h1>
            <div className="grid grid-cols-2 gap-2">
                {documents.map((document) => <div key={document.id}
                                                  className="flex flex-col items-center gap-4 border border-gray-200 py-4">
                    <p className="border-b border-black">{document.document_type.definition}</p>

                    {document.is_image ?
                        <a href={"/user-documents/" + (document.id)} target={"_blank"} className={"w-full h-48"}>
                            <img src={"/user-documents/" + (document.id)} alt="" className="w-full h-full"/>
                        </a> : null}
                    {document.is_document ? <a href={"/user-documents/" + (document.id)}>Download Document</a> : null}
                    {document.is_pdf ?
                        <iframe src={"/user-documents/" + (document.id)} frameBorder="0" className="w-full"/> : null}

                    <div className="flex flex-row gap-2">
                        <button
                            className={"py-2 px-4 rounded-2xl text-white " + (document.is_approved ? 'bg-green-500 hover:bg-green-600' : 'bg-blue-500 hover:bg-blue-600')}
                            onClick={() => approveDocument(document.id)}>{document.is_approved ? 'Approved' : 'Approve'}
                        </button>
                        <button
                            className={"py-2 px-4 rounded-2xl text-white " + (document.is_rejected ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-500 hover:bg-gray-600')}
                            onClick={() => rejectDocument(document.id)}>{document.is_rejected ? 'Rejected' : 'Reject'}
                        </button>
                    </div>

                    {/*{document.is_rejected ?*/}
                    {/*    <textarea name="reject" onChange={(event) => onChangeHandler(event, document.id)}*/}
                    {/*              cols="30" rows="10" className="rounded-2xl"*/}
                    {/*              placeholder="Enter reject reason"/> : null}*/}
                </div>)}
            </div>

            {documents.filter((document) => document.is_approved === true).length === documents.length ?
                <div className="flex flex-col gap-4 mt-4">
                    {companies.length > 0 ? <div className="flex flex-col gap-2">
                        <label htmlFor="company">Select Company</label>
                        <select name="company" id="company" onChange={onChangeHandler} className="rounded-lg">
                            {companies.map((company) => <option value={company.id}>{company.name}</option>)}
                        </select>
                    </div> : null}

                    {jobRoles.length > 0 ? <div className="flex flex-col gap-2">
                        <label htmlFor="job-role">Select Job Role</label>
                        <select name="job-role" id="job-role" onChange={onChangeHandler} className="rounded-lg">
                            {jobRoles.map((jobRole) => <option value={jobRole.id}>{jobRole.definition}</option>)}
                        </select>
                    </div> : null}

                    <label htmlFor="phone-no">Phone Number (Country code must be entered)</label>
                    <input type="tel" className="rounded-lg" placeholder="+90 533 555 444 44 44" name="phone-no" onChange={onChangeHandler}/>

                    <label htmlFor="company-phone-no">Company Phone Number (Country code must be entered)</label>
                    <input type="tel" className="rounded-lg" placeholder="+90 533 555 444 44 44" name="company-phone-no" onChange={onChangeHandler}/>
                </div> : null}

            {documents.filter((document) => document.is_rejected === true).length > 0 ?
                <textarea name="reject-reason" onChange={(event) => onChangeHandler(event, document.id)}
                          cols="30" rows="10" className="rounded-2xl"
                          placeholder="Enter reject reason"/> : null}

            <div className="flex flex-row justify-end gap-2 mt-4">
                {documents.filter((document) => document.is_approved === true).length === documents.length ? <button
                    className={"py-2 px-4 rounded-2xl text-white bg-green-500 hover:bg-green-600"}
                    onClick={approveApplication}>Approve Application
                </button> : null}
                {documents.filter((document) => document.is_rejected === true).length > 0 ? <button
                    className={"py-2 px-4 rounded-2xl text-white bg-red-500 hover:bg-red-600"}
                    onClick={rejectApplication}>Reject Application
                </button> : null}
            </div>
        </div> : <div className="flex flex-col text-center h-24 mt-12 items-center justify-center">
            {application?.status === 'approved' ? <div className="flex flex-col items-center justify-center gap-2">
                <svg className="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Application Approved
            </div> : null}

            {application?.status === 'rejected' ? <div className="flex flex-col items-center justify-center gap-2">
                <svg className="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Application Rejected
            </div> : null}
        </div>}
    </>
}

let app = document.getElementById('application');
if (app) {
    const applicationId = app.getAttribute('data-id');
    const root = createRoot(app);
    root.render(<Application applicationId={applicationId}/>);
}
