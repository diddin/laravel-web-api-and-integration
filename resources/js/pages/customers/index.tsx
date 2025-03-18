import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type SharedData} from '@/types';
import { Head, Link, usePage, useForm } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Customers',
        href: '/customers',
    },
];

type Customer = {
    'id' : any,
    'name': string,
    'email' : string,
    'address' : string,
    'city' : string,
    'state' : string,
    'postalCode': string
}

interface CustomerPageProps extends SharedData {
    customers: Customer[];
}

export default function Customers() {
    const page = usePage<CustomerPageProps>();
    const customers = page.props.customers as Customer[];
    
    const { delete: destroy} = useForm();
    //const destroyPost: FormEventHandler = (e: any, id: number): void => {
    const destroyCustomer = (e: any, id: number): void => {
        e.preventDefault();
        if(confirm("Are you sure want to remove this post")) {
            destroy(route('customers.destroy', id));
        }
    } 
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Customers" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div>
                    <Link
                        href={route('posts.create')}
                        className='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-sm text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800'
                    > Create Post </Link>
                </div>
                <div className="relative overflow-x-auto">
                    <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" className="px-6 py-3">ID</th>
                                <th scope="col" className="px-6 py-3">Name</th>
                                <th scope="col" className="px-6 py-3">Email</th>
                                <th scope="col" className="px-6 py-3">Address</th>
                                <th scope="col" className="px-6 py-3">City</th>
                                <th scope="col" className="px-6 py-3">State</th>
                                <th scope="col" className="px-6 py-3">Postal Code</th>
                                <th scope="col" className="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        {customers.map(({id, name, email, address, city, state, postalCode}: Customer) => (
                            <tr key={id} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {id}
                                </td>
                                <td className="px-6 py-4">{name}</td>
                                <td className="px-6 py-4">{email}</td>
                                <td className="px-6 py-4">{address}</td>
                                <td className="px-6 py-4">{city}</td>
                                <td className="px-6 py-4">{state}</td>
                                <td className="px-6 py-4">{postalCode}</td>
                                <td className="px-6 py-4">
                                    <form onSubmit={(e) => destroyCustomer(e, id)}>
                                    <Link href={route('customers.edit', id)} className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</Link>
                                    <button className="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
