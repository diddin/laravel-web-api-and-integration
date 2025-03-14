import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage, useForm } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/posts',
    },
];

type Post = {
    'id' : any,
    'title': string,
    'content' : string
}

export default function Posts() {
    const { posts: posts } = usePage().props as unknown as { posts: Post[] };
    
    const { delete: destroy} = useForm();
    //const destroyPost: FormEventHandler = (e: any, id: number): void => {
    const destroyPost = (e: any, id: number): void => {
        e.preventDefault();
        if(confirm("Are you sure want to remove this post")) {
            destroy(route('posts.destroy', id));
        }
    } 
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Posts" />
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
                                <th scope="col" className="px-6 py-3">Title</th>
                                <th scope="col" className="px-6 py-3">Content</th>
                                <th scope="col" className="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        {posts.map(({id, title, content}: Post) => (
                            <tr key={id} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {id}
                                </td>
                                <td className="px-6 py-4">{title}</td>
                                <td className="px-6 py-4">{content}</td>
                                <td className="px-6 py-4">
                                    <form onSubmit={(e) => destroyPost(e, id)}>
                                    <Link href={route('posts.edit', id)} className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</Link>
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
