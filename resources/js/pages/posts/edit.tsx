import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Textarea } from '@headlessui/react';
import { FormEventHandler } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Post Edit',
        href: '/posts',
    },
];

// Define the Post interface
interface Post {
    id: number;
    title: string;
    content: string;
}

export default function PostEdit() {

    const { post: post } = usePage().props as unknown as { post: Post }

    const {data, setData, errors, put} = useForm({
        'title' : post.title || "",
        'content' : post.content || ""
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        put(route('posts.update', post.id));
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Posts" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div>
                    <Link
                        href={route('posts.index')}
                        className='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-sm text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800'
                    >Back</Link>
                </div>
                <form onSubmit={submit} className="space-y-6">  
                    <div className="grid gap-2">
                        <Label htmlFor="name">Title</Label>
                        <Input
                            id="title"
                            className="mt-1 block w-full"
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                            // required
                            autoComplete="title"
                            placeholder="Title"
                        />
                        <InputError className="mt-2" message={errors.title} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="name">Content</Label>
                        <Textarea
                            id="content"
                            className="border-input file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground flex h-60 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                            value={data.content}
                            onChange={(e) => setData('content', e.target.value)}
                            // required
                            autoComplete="content"
                            placeholder="Content"
                        ></Textarea>
                        <InputError className="mt-2" message={errors.content} />
                    </div>
                    <Button>Save</Button>
                </form>
            </div>
        </AppLayout>
    );
}
