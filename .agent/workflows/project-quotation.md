---
description: Procedures for managing Project Quotations, including creation, validation, and printing.
---

# Project Quotation Module Workflow

This workflow describes the end-to-end process for creating and managing project quotations within the SSB Project management system.

## 1. Accessing the Module
1. Navigate to the **Quotation Dashboard** from the main sidebar.
2. Review the KPI cards for an overview of Drafts, Pending Approvals, and Total Value.

## 2. Creating a New Quotation
1. Click the **"Create New Quote"** button in the dashboard header.
2. **Step 1: Project Selection**
   - Select the **Project** for which the quotation is being made.
   - The system will automatically fetch the latest approved **Budget Baseline** (HPP) for this project.
   - Select the specific **Budget Version** if applicable.
3. **Step 2: Unit Selection & Pricing**
   - Click **"+ Add Unit"** to add a new item row.
   - **Select Unit**: Use the search-enabled dropdown to pick the equipment or service. 
     - *Validation*: The system prevents selecting duplicate units in a single quotation.
   - **Rate (Rp)**: Enter the unit price. 
     - *Format*: Numbers include automatic thousand separators (e.g., `1.000.000`) for readability.
   - **Qty & Duration**: Enter the quantity and work duration.
     - *Note*: Duration only accepts whole numbers (integers).
   - **Dynamic Calculation**: The "Total (Rp)" for each row and the "Grand Total" are updated in real-time.

## 3. Profit Planning & Analysis
1. Navigate to the **"Profit Planning"** tab or section.
2. Review the **Total HPP** extracted from the project budget.
3. Enter your desired **Profit Margin (%)**.
4. The system calculates the **Target Selling Price** based on: `HPP * (1 + Margin/100)`.
5. Compare the **Current Revenue** (from items) against the **Target Selling Price**.
   - **Surplus**: You are charging more than the target.
   - **Deficit**: You need to increase item rates to achieve the desired margin.
   - **Balanced**: Revenue matches the target margin exactly.

## 4. Finalizing and Submission
1. Review the **Terms & Conditions** and set the **Valid Until** date.
2. Click **"Submit Quotation"**.
3. Upon success, you will be redirected to the **Quotation Detail Page**.
4. Review the final breakdown. If everything is correct, click **"Submit for Approval"** to initiate the workflow defined in the Approval Matrix.

## 5. Printing and Distribution
1. From the Quotation Detail or Dashboard, click the **"PDF"** or **"Print PDF"** button.
2. The system generates a professional document with company branding (PT. SUMBER SETIA BUDI).
3. Download or print the file for the client.

## Technical Validation Notes
- **Numeric Inputs**: Automatically blocks scientific notation keys ('e', '+', '-').
- **Separators**: Dots are automatically added on input but stripped before saving to the database.
- **Scrolling**: The unit table supports horizontal scrolling for narrow windows; Select2 dropdowns support vertical scrolling for large catalogs.
