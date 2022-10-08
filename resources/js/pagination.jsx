import React from "react";

export default function Pagination({data, clickHandler}) {

    const hasMorePage = () => {
        return data.current_page < data.last_page;
    }

    const nextPage = () => {
        return data.next_page_url;
    }

    const previousPage = () => {
        let page = data.current_page - 1;
        if(page < 1) {
            return null;
        }

        return data.path + '?page=' + page;
    }

    return <>
        {data?.last_page > 1 ? <div className="flex flex-row justify-between mt-4">
            <span>Last Page: {data?.last_page} / Current Page: {data?.current_page}</span>
            <div className="flex flex-row divide-x divide-gray-300">
                <button className="py-2 px-4 bg-gray-400 text-white hover:bg-gray-500 rounded-l-lg" onClick={() => clickHandler(previousPage())}>Previous</button>
                <button className="py-2 px-4 bg-gray-400 text-white hover:bg-gray-500 rounded-r-lg" onClick={() => clickHandler(nextPage())}>Next</button>
            </div>
        </div> : null}
    </>
}
