<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Simpanan</title>
    <style>
        /* Base styles */
        :root {
            --accent: rgb(93, 135, 255);
            --accent-light: rgba(93, 135, 255, 0.1);
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.5;
            color: var(--gray-800);
            background-color: var(--gray-50);
            font-size: 16px;
        }

        /* Layout */
        .max-w-4xl {
            max-width: 56rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .my-8 {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        /* Card styling */
        .bg-dark {
            background-color: var(--white);
        }

        .bg-gray-50 {
            background-color: var(--gray-50);
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .border-b,
        .border-t {
            border-bottom-width: 1px;
            border-bottom-style: solid;
        }

        .border-t {
            border-top-width: 1px;
            border-top-style: solid;
        }

        .border-gray-200 {
            border-color: var(--gray-200);
        }

        /* Typography */
        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-accent {
            color: var(--accent);
        }

        .text-gray-600 {
            color: var(--gray-600);
        }

        .text-gray-500 {
            color: var(--gray-500);
        }

        .text-gray-700 {
            color: var(--gray-700);
        }

        .text-white {
            color: var(--white);
        }

        /* Flex */
        .flex {
            display: flex;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .inline-block {
            display: inline-block;
        }

        /* Table */
        .w-full {
            width: 100%;
        }

        .border-collapse {
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }

        th,
        td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        th {
            font-weight: 600;
            color: var(--gray-700);
            background-color: var(--gray-50);
        }

        tbody tr:nth-child(even) {
            background-color: var(--gray-50);
        }

        tbody tr:hover {
            background-color: var(--gray-100);
        }

        /* Button */
        .bg-accent {
            background-color: var(--accent);
        }

        .hover\:bg-accent\/90:hover {
            background-color: rgba(93, 135, 255, 0.9);
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .focus\:outline-none:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .focus\:ring-2:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }

        .focus\:ring-accent:focus {
            --tw-ring-color: var(--accent);
        }

        .focus\:ring-opacity-50:focus {
            --tw-ring-opacity: 0.5;
        }

        /* Background accent */
        .bg-accent\/10 {
            background-color: rgba(93, 135, 255, 0.1);
        }

        /* Print styles */
        @media print {
            body {
                background-color: white;
            }

            .print\:hidden {
                display: none !important;
            }
        }

        /* Responsive */
        @media (min-width: 640px) {
            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800 antialiased">
    <div class="mx-auto my-8 max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="bg-dark overflow-hidden rounded-lg shadow-lg">
            <div class="bg-accent/10 border-b border-gray-200 px-6 py-8">
                <h1 class="text-accent text-center text-3xl font-bold">Daftar Simpanan</h1>
                <p class="mt-2 text-center text-gray-600">
                    Total: {{ count($simpanan) }} Anggota
                </p>
            </div>

            <div class="font-sans overflow-hidden px-6 py-6">
                <div class="overflow-auto">
                    <table>
                        <thead>
                            <tr>
                                <th class="font-sans">Nama Anggota</th>
                                <th class="font-sans">Simpanan Pokok</th>
                                <th class="font-sans">Simpanan Wajib</th>
                                <th class="font-sans">Simpanan Sukarela</th>
                                <th class="font-sans">Total Simpanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($simpanan as $s)
                                <tr>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ number_format($s->total_pokok, 0, ',', '.') }}</td>
                                    <td>{{ number_format($s->total_wajib, 0, ',', '.') }}</td>
                                    <td>{{ number_format($s->total_sukarela, 0, ',', '.') }}</td>
                                    <td>{{ number_format($s->total_jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-500 print:hidden">
            Diekspor pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
</body>

</html>
