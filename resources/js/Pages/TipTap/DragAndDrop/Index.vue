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
import Document from "@tiptap/extension-document";
import Gapcursor from "@tiptap/extension-gapcursor";
import Paragraph from "@tiptap/extension-paragraph";
import Text from "@tiptap/extension-text";
import BulletList from "@tiptap/extension-bullet-list";
import ListItem from "@tiptap/extension-list-item";
import Underline from "@tiptap/extension-underline";
import OrderedList from "@tiptap/extension-ordered-list";

const editor = ref(null);
const editorDragItemContent = ref(null);
onMounted(() => {
    editorDragItemContent.value = new Editor({
        extensions: [StarterKit, DraggableItem],
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
                <p>fifth item.</p>
            </div>
        `,
    });
    editor.value = new Editor({
        extensions: [
            StarterKit,
            OrderedList,
            ListItem,
            Document,
            Paragraph,
            Text,
            Gapcursor,
            TableRow,
            TableCell,
            TableHeader,
            Underline,
            Table.configure({
                resizable: true,
            }),
            BulletList.configure({
                HTMLAttributes: {
                    class: "my-custom-class",
                },
                itemTypeName: "listItem",
                keepMarks: true,
            }),
            DraggableItem,
        ],
        content: `
            <p>test paragraph</p>  
           
        `,
    });
});
{
    /* <h4 style="margin-top: 2rem;">Table</h4>
            <table >
                <tbody>
                    <tr>
                        <th >Column 1</th>
                        <th>Column 2</th>
                        <th >Column 3</th>
                    </tr>
                    <tr>
                        <td >Column 1</td>
                        <td>Column 2</td>
                        <td>Column 3</td>
                    </tr>
                </tbody>
            </table> */
}

onBeforeUnmount(() => {
    editor.value.destroy();
});

const showTableModal = ref(false);
const showCreateTableModal = ref(false);
const gridSelector = ref(null);
const editorContainer = ref(null);
const selectedRows = ref(0);
const selectedCols = ref(0);

const handleClickShowTableModal = () => {
    showTableModal.value = true;
    showCreateTableModal.value = false;
};

const handleCloseShowTableModal = () => {
    showTableModal.value = false;
};

const showDragItemModal = ref(false);

const handleClickShowIconModal = () => {
    showDragItemModal.value = true;
};

const handleCloseShowIconModal = () => {
    showDragItemModal.value = false;
};

const handleClickShowCreateTableModal = () => {
    showCreateTableModal.value = true;
    handleCloseShowTableModal();
};

const handleCloseShowCreateTableModal = () => {
    showCreateTableModal.value = false;
};

const highlightCells = (index) => {
    const cols = 10;
    const row = Math.floor(index / cols) + 1;
    const col = (index % cols) + 1;
    selectedRows.value = row;
    selectedCols.value = col;
};

// Check if cell should be highlighted
const isSelected = (index) => {
    const cols = 10;
    const row = Math.floor(index / cols) + 1;
    const col = (index % cols) + 1;
    return row <= selectedRows.value && col <= selectedCols.value;
};

// Insert table in Tiptap editor
const insertTable = () => {
    if (selectedRows.value > 0 && selectedCols.value > 0) {
        editor.value
            .chain()
            .focus()
            .insertTable({
                rows: selectedRows.value,
                cols: selectedCols.value,
                withHeaderRow: true,
            })
            .run();
    }
};
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
        background-color: palevioletred;
        border-radius: 0.4rem;
        color: black;
        font-size: 0.85rem;
        padding: 0.25em 0.3em;
    }

    pre {
        background: black;
        border-radius: 0.5rem;
        color: white;
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
        border-left: 3px solid gray;
        margin: 1.5rem 0;
        padding-left: 1rem;
    }

    hr {
        border: none;
        border-top: 1px solid gray;
        margin: 2rem 0;
    }
    table {
        border-collapse: collapse;
        margin: 0;
        overflow: hidden;
        table-layout: fixed;
        width: 100%;

        td,
        th {
            border: 1px solid black !important;
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
            background-color: gray;
            font-weight: bold;
            text-align: left;
        }
        .selectedCell:after {
            background: red;
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
            background-color: purple;
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
.grid-selector {
    display: inline-grid;
    grid-template-columns: repeat(10, 20px);
    grid-template-rows: repeat(10, 20px);
    gap: 2px;
    margin-bottom: 10px;
}

.grid-cell {
    width: 20px;
    height: 20px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    cursor: pointer;
}

.grid-cell.selected {
    background-color: #007bff;
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
                    <div v-if="showDragItemModal">
                        <div v-if="editor" class="container">
                            <div class="control-group">
                                <editor-content
                                    :editor="editorDragItemContent"
                                />
                            </div>
                        </div>
                    </div>
                    <div v-if="showCreateTableModal">
                        <div v-if="editor" class="container">
                            <div class="control-group">
                                <div class="button-group">
                                    <!-- Columns:
                                    <input
                                        type="number"
                                        placeholder="number of columns"
                                        label="columns"
                                        v-model="tableColumns"
                                    />
                                    Rows:
                                    <input
                                        type="number"
                                        placeholder="number of rows"
                                        label="rows"
                                        v-model="tableRows"
                                    />
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .insertTable({
                                                    rows: tableRows,
                                                    cols: tableColumns,
                                                    withHeaderRow: true,
                                                })
                                                .run(),
                                                handleClickShowTableModal()
                                        "
                                    >
                                        Create Table
                                    </button> -->
                                    <div
                                        ref="gridSelector"
                                        class="grid-selector"
                                    >
                                        <div
                                            v-for="(cell, index) in 100"
                                            :key="index"
                                            class="grid-cell"
                                            :class="{
                                                selected: isSelected(index),
                                            }"
                                            @mouseover="highlightCells(index)"
                                            @click="insertTable"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="showTableModal">
                        <div v-if="editor" class="container">
                            <div class="control-group">
                                <div class="button-group">
                                    <button
                                        @click="handleClickShowCreateTableModal"
                                    >
                                        Insert table
                                    </button>

                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .addColumnBefore()
                                                .run()
                                        "
                                    >
                                        Add column before
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .addColumnAfter()
                                                .run()
                                        "
                                    >
                                        Add column after
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .deleteColumn()
                                                .run()
                                        "
                                    >
                                        Delete column
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .addRowBefore()
                                                .run()
                                        "
                                    >
                                        Add row before
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .addRowAfter()
                                                .run()
                                        "
                                    >
                                        Add row after
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .deleteRow()
                                                .run()
                                        "
                                    >
                                        Delete row
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .deleteTable()
                                                .run()
                                        "
                                    >
                                        Delete table
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .mergeCells()
                                                .run()
                                        "
                                    >
                                        Merge cells
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .splitCell()
                                                .run()
                                        "
                                    >
                                        Split cell
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleHeaderColumn()
                                                .run()
                                        "
                                    >
                                        Toggle header column
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleHeaderRow()
                                                .run()
                                        "
                                    >
                                        Toggle header row
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .toggleHeaderCell()
                                                .run()
                                        "
                                    >
                                        Toggle header cell
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .mergeOrSplit()
                                                .run()
                                        "
                                    >
                                        Merge or split
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .setCellAttribute('colspan', 2)
                                                .run()
                                        "
                                    >
                                        Set cell attribute
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .fixTables()
                                                .run()
                                        "
                                    >
                                        Fix tables
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .goToNextCell()
                                                .run()
                                        "
                                    >
                                        Go to next cell
                                    </button>
                                    <button
                                        @click="
                                            editor
                                                .chain()
                                                .focus()
                                                .goToPreviousCell()
                                                .run()
                                        "
                                    >
                                        Go to previous cell
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="editor" class="container">
                        <div class="control-group">
                            <div class="button-group">
                                <button
                                    @click="editor.chain().focus().undo().run()"
                                    :disabled="!editor.can().undo()"
                                >
                                    ↶
                                </button>
                                <button
                                    @click="editor.chain().focus().redo().run()"
                                    :disabled="!editor.can().redo()"
                                >
                                    ↷
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleBold()
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive('bold'),
                                    }"
                                >
                                    𝐁
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleItalic()
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive('italic'),
                                    }"
                                >
                                    𝐼
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleUnderline()
                                            .run()
                                    "
                                    :class="{
                                        'is-active':
                                            editor.isActive('underline'),
                                    }"
                                >
                                    U̲
                                </button>
                                <!-- <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleBulletList()
                                            .run()
                                    "
                                    :class="{
                                        'is-active':
                                            editor.isActive('bulletList'),
                                    }"
                                >
                                    <svg
                                        fill="#000000"
                                        width="18px"
                                        height="18px"
                                        viewBox="0 0 56 56"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M 7.3398 16.7617 C 8.9804 16.7617 10.2929 15.4492 10.2929 13.8320 C 10.2929 12.1914 8.9804 10.8789 7.3398 10.8789 C 5.7226 10.8789 4.3867 12.1914 4.3867 13.8320 C 4.3867 15.4492 5.7226 16.7617 7.3398 16.7617 Z M 17.6992 15.7070 L 49.7149 15.7070 C 50.7930 15.7070 51.6133 14.8867 51.6133 13.8320 C 51.6133 12.7539 50.7930 11.9336 49.7149 11.9336 L 17.6992 11.9336 C 16.6445 11.9336 15.8242 12.7539 15.8242 13.8320 C 15.8242 14.8867 16.6445 15.7070 17.6992 15.7070 Z M 7.3398 30.9414 C 8.9804 30.9414 10.2929 29.6289 10.2929 27.9883 C 10.2929 26.3477 8.9804 25.0352 7.3398 25.0352 C 5.7226 25.0352 4.3867 26.3477 4.3867 27.9883 C 4.3867 29.6289 5.7226 30.9414 7.3398 30.9414 Z M 17.6992 29.8867 L 49.7149 29.8867 C 50.7930 29.8867 51.6133 29.0430 51.6133 27.9883 C 51.6133 26.9336 50.7930 26.1133 49.7149 26.1133 L 17.6992 26.1133 C 16.6445 26.1133 15.8242 26.9336 15.8242 27.9883 C 15.8242 29.0430 16.6445 29.8867 17.6992 29.8867 Z M 7.3398 45.1211 C 8.9804 45.1211 10.2929 43.7852 10.2929 42.1680 C 10.2929 40.5273 8.9804 39.2148 7.3398 39.2148 C 5.7226 39.2148 4.3867 40.5273 4.3867 42.1680 C 4.3867 43.7852 5.7226 45.1211 7.3398 45.1211 Z M 17.6992 44.0430 L 49.7149 44.0430 C 50.7930 44.0430 51.6133 43.2227 51.6133 42.1680 C 51.6133 41.0898 50.7930 40.2695 49.7149 40.2695 L 17.6992 40.2695 C 16.6445 40.2695 15.8242 41.0898 15.8242 42.1680 C 15.8242 43.2227 16.6445 44.0430 17.6992 44.0430 Z"
                                        />
                                    </svg>
                                </button> -->
                                <button
                                    v-if="!showTableModal"
                                    @click="handleClickShowTableModal"
                                >
                                    Table
                                </button>
                                <button
                                    v-if="showTableModal"
                                    @click="handleCloseShowTableModal"
                                >
                                    Close Table Modal
                                </button>
                                <button
                                    v-if="!showDragItemModal"
                                    @click="handleClickShowIconModal"
                                >
                                    Tokens
                                </button>
                                <button
                                    v-if="showDragItemModal"
                                    @click="handleCloseShowIconModal"
                                >
                                    Tokens
                                </button>
                            </div>
                        </div>
                        <div class="mt-20">
                            <editor-content :editor="editor" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
