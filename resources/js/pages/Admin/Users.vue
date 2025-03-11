<script setup lang="ts">
import Alerts from '@/components/AllApp/Alerts.vue';
import DynamicCreate from '@/components/Model/DynamicCreate.vue';
import DynamicDelete from '@/components/Model/DynamicDelete.vue';
import DynamicEdit from '@/components/Model/DynamicEdit.vue';
import DataTable from '@/components/Table/DataTable.vue';
import TBody from '@/components/Table/TBody.vue';
import Thedar from '@/components/Table/Thedar.vue';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ChevronDown, ChevronLeft, ChevronRight, PencilIcon, Search, TrashIcon, UserPlus } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
// تعريف الأنواع
interface ColumnName {
    name: string;
    id?: string | number;
}

interface Column {
    key: string;
    label: string;
    name: string;
    type: string;
    showInCreate: boolean;
    showInEdit: boolean;
    showInTabel: boolean;
    required: boolean;
    disabled: boolean;
    placeholder: string;
    options?: Array<{ label: string; value: string }>;
    multiple?: boolean;
}

interface ModelData {
    id?: number;
    name?: string;
    email?: string;
    roles?: Array<{ name: string }>;
    [key: string]: any;
}

interface User {
    id: number;
    name: string;
    email: string;
    roles?: Array<{ name: string }>;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];
const data2 = ref<Record<string, any> | null>(null);
const errors = ref<Record<string, any> | null>(null);

const columnsName: ColumnName[] = [{ name: '#' }, { name: 'Name' }, { name: 'Email' }, { name: 'Actions' }];

const columns: Column[] = [
    {
        key: 'id',
        label: 'ID',
        name: 'id',
        type: 'text',
        showInCreate: false,
        showInEdit: false,
        showInTabel: true,
        required: false,
        disabled: true,
        placeholder: '',
    },
    {
        key: 'actions',
        label: 'Actions',
    },
    {
        key: 'name',
        label: 'Name',
        name: 'name',
        type: 'text',
        required: true,
        disabled: false,
        showInCreate: true,
        showInTabel: true,
        showInEdit: true,
        placeholder: 'Enter Name',
    },
    {
        key: 'email',
        label: 'Email',
        name: 'email',
        type: 'email',
        showInCreate: true,
        showInTabel: true,
        showInEdit: true,
        required: true,
        disabled: false,
        placeholder: 'Enter Email',
    },
    {
        key: 'password',
        label: 'Password',
        name: 'password',
        type: 'password',
        showInCreate: true,
        showInEdit: false,
        required: true,
        showInTabel: false,
        disabled: false,
        placeholder: 'Enter Password',
    },
    {
        key: 'password_confirmation',
        label: 'Password Confirmation',
        name: 'password_confirmation',
        type: 'password',
        showInTabel: false,
        showInCreate: true,
        showInEdit: false,
        required: true,
        disabled: false,
        placeholder: 'Enter password Confirmation',
    },
];
const page = usePage<{ users: User[] }>();
const users = computed(() => page.props.users);

const showCreateModel = ref(false);
const showEditModel = ref(false);

const showDeleteModel = ref(false);
const showAlert = ref(false);
const alertMessage = ref('');
const alertTitle = ref('');

const modelData = ref<ModelData>({});

const openCreateModel = () => {
    showCreateModel.value = true;
    modelData.value = {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    };
};
const createUser = (data: ModelData) => {
    console.log(data);

    router.post('/admin/users', data, {
        onSuccess: (data) => {
            console.log(data);
            closeModal();

            showAlert.value = true;
            alertTitle.value = 'success';
            alertMessage.value = 'User created successfully.';
            setTimeout(() => {
                showAlert.value = false;
            }, 3000);
        },
        onError: (data) => {
            errors.value = data;

            showAlert.value = true;
            alertTitle.value = 'error';
            alertMessage.value = 'Failed to create user.';
            setTimeout(() => {
                showAlert.value = false;
            }, 3000);
            console.log(data);
        },
    });
};

const openEditModel = (data: ModelData) => {
    showEditModel.value = true;
    modelData.value = { ...data };
};
const updateData = (updatedData: ModelData) => {
    console.log(updatedData);
    router.put(`/admin/users/${updatedData.id}`, updatedData, {
        onSuccess: (data) => {
            console.log(data);
            closeModal();

            showAlert.value = true;
            alertTitle.value = 'success';
            alertMessage.value = 'User updated successfully.';
            setTimeout(() => {
                showAlert.value = false;
            }, 3000);
        },
        onError: (data) => {
            errors.value = data;

            showAlert.value = true;
            alertTitle.value = 'error';
            alertMessage.value = 'Failed to update user.';
            setTimeout(() => {
                showAlert.value = false;
            }, 3000);
            console.log(data);
        },
    });
};
const openDeleteModel = (data: ModelData) => {
    console.log(data);
    showDeleteModel.value = true;
    modelData.value = { ...data };
};

const deleteData = (data: ModelData) => {
    router.delete(`/admin/users/${data.id}`, {
        onSuccess: (data) => {
            closeModal();

            showAlert.value = true;
            alertTitle.value = 'success';
            alertMessage.value = 'User deleted successfully.';
            setTimeout(() => {
                showAlert.value = false;
            }, 3000);
            console.log(data);
        },
    });
};
const closeModal = () => {
    errors.value = null;
    showCreateModel.value = false;
    showEditModel.value = false;
    showDeleteModel.value = false;
};

const itemsPerPage = ref(10);
const search = ref('');

watch(itemsPerPage, (newValue) => {
    router.get(
        route('users.index', {
            per_page: newValue,
            search: search.value,
        }),
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
});

//////////////////

import debounce from 'lodash/debounce';
watch(
    search,
    debounce(function (newValue) {
        router.get(
            '/admin/users',
            {
                search: newValue,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            },
        );
    }, 500),
);
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Alerts v-if="showAlert" :title="alertTitle" :message="alertMessage" />
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="relative overflow-hidden rounded-xl border bg-card text-card-foreground shadow">
                <Button @click="openCreateModel" variant="outline" size="lg" class="w-full">
                    <UserPlus class="" />
                    <span class="">Create</span>
                </Button>
                <div class="flex-column flex-wrap items-center justify-between space-x-4 space-y-4 pb-4 sm:flex-row sm:space-y-0">
                    <div class="mx-4 flex w-full max-w-sm items-center space-x-2">
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Search class="h-5 w-5 text-muted-foreground" />
                            </div>
                            <Input
                                @input="search = $event.target.value"
                                v-model="search"
                                id="search"
                                type="search"
                                placeholder="Search users..."
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 pl-10 pr-4 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                            />
                        </div>

                        <div class="items-center space-x-2">
                            <DropdownMenu>
                                <DropdownMenuTrigger asChild>
                                    <Button variant="outline" size="sm" class="flex items-center gap-2">
                                        <span>Show: {{ itemsPerPage }}</span>
                                        <ChevronDown class="h-4 w-4" />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent class="w-40">
                                    <DropdownMenuItem
                                        v-for="size in [5, 10, 15, 25, 50]"
                                        :key="size"
                                        @click="itemsPerPage = size"
                                        :class="{ 'bg-accent': itemsPerPage === size }"
                                    >
                                        {{ size }} items
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
                    </div>

                    <DataTable
                        :data="users.data"
                        :columnsName="columnsName"
                        :columns="columns"
                        :loading="false"
                        id="users-table"
                        :availableData="true"
                        @sort="() => {}"
                    >
                        <template #header>
                            <Thedar v-for="column in columnsName" :nameFeild="column.name" :key="column.id" />
                        </template>
                        <template #row="{ item }">
                            <TBody :item="item" :columns="columns">
                                <template #column-actions="{ item }">
                                    <Button variant="outline" size="sm" :id="(item as User).id" @click="openEditModel(item)">
                                        <PencilIcon class="size-4" />
                                        <span class="sr-only">Edit</span>
                                    </Button>
                                    <Button variant="outline" size="sm" :id="(item as User).id" @click="openDeleteModel(item)">
                                        <TrashIcon class="size-4" />
                                        <span class="sr-only">Delete</span>
                                    </Button>
                                </template>
                            </TBody>
                        </template>
                    </DataTable>
                    <div class="flex items-center justify-center space-x-2 py-4">
                        <Button
                            variant="outline"
                            size="sm"
                            class="gap-1 text-sm"
                            :disabled="!users.prev_page_url"
                            @click="router.get(users.prev_page_url)"
                        >
                            <ChevronLeft class="h-4 w-4" />
                            Previous
                        </Button>

                        <div class="flex items-center gap-1 text-sm text-muted-foreground">
                            <span>Page {{ users.current_page }} of {{ users.last_page }}</span>
                        </div>

                        <Button
                            variant="outline"
                            size="sm"
                            class="gap-1 text-sm"
                            :disabled="!users.next_page_url"
                            @click="router.get(users.next_page_url)"
                        >
                            Next
                            <ChevronRight class="h-4 w-4" />
                        </Button>
                    </div>

                    <DynamicEdit
                        :data="modelData"
                        :data2="data2"
                        :errors="errors"
                        :columns="columns"
                        :show="showEditModel"
                        @close="closeModal"
                        title="Edit User"
                        @update="updateData"
                    >
                    </DynamicEdit>
                    <DynamicDelete :show="showDeleteModel" @delete="deleteData" @close="closeModal" title="Delete User" :data="modelData">
                        <template #message="{ data }">
                            <Label class="text-lg"
                                >Are you sure you want to delete this
                                <span class="text-red-500">
                                    {{ data.name }}
                                </span>
                                user ?
                            </Label>
                        </template>
                    </DynamicDelete>
                    <DynamicCreate
                        :show="showCreateModel"
                        @close="closeModal"
                        title="Create User"
                        @create="createUser"
                        :columns="columns"
                        :errors="errors"
                        :data="modelData"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
