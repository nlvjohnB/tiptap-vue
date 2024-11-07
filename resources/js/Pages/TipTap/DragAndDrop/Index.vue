<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useEditor, EditorContent, Editor } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import { ref, onMounted, onBeforeUnmount } from "vue";
import DraggableItem from "@/Composables/draggableItem.js";
import Table from "@tiptap/extension-table";
import TableRow from "@tiptap/extension-table-row";
import TableCell from "@tiptap/extension-table-cell";
import TableHeader from "@tiptap/extension-table-header";
import Gapcursor from "@tiptap/extension-gapcursor";

const editor = ref(null);
onMounted(() => {
    editor.value = new Editor({
        extensions: [
            StarterKit,
            DraggableItem,
            Gapcursor,
            Table.configure({
                resizable: true,
            }),
            TableRow,
            TableCell,
            TableHeader,
        ],
        content: `
        <h4>Draggable Items.</h4>
        <div data-type="draggable-item" style="width: 2%;">
            <p>first item.</p>
        </div>
        <div data-type="draggable-item">
            
            <p>second item.</p>
        </div>
        <div data-type="draggable-item">
            <p>third item.</p>
            
        </div>
        <div data-type="draggable-item">
            <p>fourth item.</p>
          </div>
        <div data-type="draggable-item">
        <p>fith item.</p>
        </div>

        <!-- Table added below -->
        <h4 style="margin-top: 2rem;">Table</h4>
       <table >
             <tbody>
                <tr>
                    <th >Column 1</th>
                    <th>Column 2</th>
                    <th >Column 3</th>
                </tr>
            </tbody>
        </table>
    `,
    });
});

onBeforeUnmount(() => {
    editor.value.destroy();
});
</script>

<style lang="scss">
.tiptap {
    :first-child {
        margin-top: 0;
    }

    /* List styles */
    ul,
    ol {
        padding: 0 1rem;
        margin: 1.25rem 1rem 1.25rem 0.4rem;

        li p {
            margin-top: 0.25em;
            margin-bottom: 0.25em;
        }
    }

    /* Heading styles */
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        line-height: 1.1;
        margin-top: 2.5rem;
        text-wrap: pretty;
    }

    h1,
    h2 {
        margin-top: 3.5rem;
        margin-bottom: 1.5rem;
    }

    h1 {
        font-size: 1.4rem;
    }

    h2 {
        font-size: 1.2rem;
    }

    h3 {
        font-size: 1.1rem;
    }

    h4,
    h5,
    h6 {
        font-size: 1rem;
    }

    /* Code and preformatted text styles */
    code {
        background-color: var(--purple-light);
        border-radius: 0.4rem;
        color: var(--black);
        font-size: 0.85rem;
        padding: 0.25em 0.3em;
    }

    pre {
        background: var(--black);
        border-radius: 0.5rem;
        color: var(--white);
        font-family: "JetBrainsMono", monospace;
        margin: 1.5rem 0;
        padding: 0.75rem 1rem;

        code {
            background: none;
            color: inherit;
            font-size: 0.8rem;
            padding: 0;
        }
    }

    blockquote {
        border-left: 3px solid var(--gray-3);
        margin: 1.5rem 0;
        padding-left: 1rem;
    }

    hr {
        border: none;
        border-top: 1px solid var(--gray-2);
        margin: 2rem 0;
    }

    // .custom-table {
    //     width: 100%;
    //     border-collapse: collapse;
    //     font-family: Arial, sans-serif !important;
    //     border: 2px solid #333 !important;
    // }

    // .custom-table th,
    // .custom-table td {
    //     padding: 10px;
    //     border: 1px solid #333 !important; /* Darker border for grid-like effect */
    // }

    // .custom-table thead {
    //     background-color: #f2f2f2 !important;
    // }

    // .custom-table tbody tr:nth-child(even) {
    //     background-color: #f9f9f9 !important;
    // }

    table {
        border-collapse: collapse;
        margin: 0;
        overflow: hidden;
        table-layout: fixed;
        width: 100%;

        td,
        th {
            border: 1px solid var(--gray-3) !important;
            box-sizing: border-box;
            min-width: 1em;
            padding: 6px 8px;
            position: relative;
            vertical-align: top;

            > * {
                margin-bottom: 0;
            }
        }

        th {
            background-color: var(--gray-1);
            font-weight: bold;
            text-align: left;
        }
        .selectedCell:after {
            background: var(--gray-2);
            content: "";
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            pointer-events: none;
            position: absolute;
            z-index: 2;
        }
        .column-resize-handle {
            background-color: var(--purple);
            bottom: -2px;
            pointer-events: none;
            position: absolute;
            right: -2px;
            top: 0;
            width: 4px;
        }
    }
    .tableWrapper {
        margin: 1.5rem 0;
        overflow-x: auto;
    }

    &.resize-cursor {
        cursor: ew-resize;
        cursor: col-resize;
    }
}
</style>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Drag and Drop
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-4 mx-4 py-4"
                >
                    <div v-if="editor">
                        <editor-content :editor="editor" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
