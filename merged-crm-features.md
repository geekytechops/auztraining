# Modern College CRM — Enquiry Module & Platform Features

This document combines the **Enquiry Module** requirements with **broader CRM platform upgrades**. Part 1 covers day-to-day enquiry, counselling, dashboards, appointments, and login behaviour. Part 2 explains additional upgrades in plain language for clients and staff.

**Table of contents**

- [Part 1 — Enquiry Module & CRM operations](#part-1--enquiry-module--crm-operations)
  - [1.1 Create Enquiry](#11-create-enquiry)
  - [1.2 Enquiry list, filters & columns](#12-enquiry-list-filters--columns)
  - [1.3 Callback reminder](#13-callback-reminder)
  - [1.4 Escalation, counselling & appointment reminders](#14-escalation-counselling--appointment-reminders)
  - [1.5 Counselling bookings](#15-counselling-bookings)
  - [1.6 Quick View](#16-quick-view)
  - [1.7 Personalised employee dashboard (staff)](#17-personalised-employee-dashboard-staff)
  - [1.8 Notification center](#18-notification-center)
  - [1.9 Lead distribution (supervisor / admin)](#19-lead-distribution-supervisor--admin)
  - [1.10 Admin & supervisor dashboard](#110-admin--supervisor-dashboard)
  - [1.11 Appointment module](#111-appointment-module)
  - [1.12 CRM login & security](#112-crm-login--security)
- [Part 2 — Platform upgrades (simplified)](#part-2--platform-upgrades-simplified)
  - [2.1 Visual enhancements](#21-visual-enhancements)
  - [2.2 Smart backend & automation](#22-smart-backend--automation)
  - [2.3 Student experience](#23-student-experience)
- [Feature cross-reference](#feature-cross-reference)

---

# Part 1 — Enquiry Module & CRM operations

Requirements in this section come from the Enquiry Module specification. Wording follows the source documents (stage codes, outcomes, and access levels).

---

## 1.1 Create Enquiry

**What it does:** Improves how staff create and work through an enquiry, with a clear visual of where the student is in the pipeline and a cleaner form layout.

**Requirements**

- Modify the **Create Enquiry** flow.
- Add a **graphic progress representation** showing which stage the enquiry is in:

  `ENQ → PCFU → CON → PCFU`

- **Replace the accordion with tabs** (use the existing template pattern where available).
- In **Create Enquiry → Address**, integrate the **Google Address API** so staff can capture the student’s exact address reliably.

---

## 1.2 Enquiry list, filters & columns

**What it does:** Makes the enquiry table easier to search and customise so staff see the right leads and columns.

**Requirements**

- Add **filters** with **multi-select** support.
- **Additional filters:**
  - **Stage** filter
  - **Outcomes** filter
- **Manage columns**, including:
  - **Pending – to be confirmed**

---

## 1.3 Callback reminder

**What it does:** Schedules call-backs separately from counselling appointments, then reminds the assigned employee at the right time.

**Background**

When a user selects **“No Answer”** or **“Call Back Later”**, a calendar button can appear to schedule an appointment. That flow is **not suitable** for call-backs, because appointments are meant for meetings or counselling sessions—not for scheduling a return phone call.

A **dedicated callback reminder** is required instead of creating an appointment.

**Requirements**

- When an employee selects **“Call Back Later”**, **“No Answer”**, or **“Delayed”** from the **Outcome** dropdown in any of these sections:
  - **Enquiry**
  - **Counselling**
  - **Follow Up**
  - **Post Counselling**
- The CRM should:
  1. Show **Callback Date & Time** fields (not an appointment calendar for this purpose).
  2. Save the callback schedule.
  3. Create a **reminder / task**.
  4. Trigger a **popup (modal) notification** at the scheduled time for the assigned employee.
  5. Send **email / browser notification** where configured.

**When the user selects Call Back Later, No Answer, or Delayed, show:**

- Date picker
- Time picker
- Notes

The reminder should trigger automatically based on the selected outcome from the dropdown.

This helps ensure timely follow-ups and prevents missed call-backs.

---

## 1.4 Escalation, counselling & appointment reminders

**What it does:** Escalates neglected follow-ups to supervisors and extends reminder behaviour to counselling and appointments.

### Escalation system

If **no follow-up** is done:

| Time without follow-up | Action |
|------------------------|--------|
| Within **24 hours** | **Yellow** alert |
| Within **48 hours** | **Red** alert |
| **72 hours** | **Supervisor notified** |

This prevents staff negligence on open leads.

> **Note:** Broader “safety net” alerts in [Part 2](#23-alert--safety-net-alarm) complement this; the **24 / 48 / 72 hour** rules above are the authoritative enquiry escalation timings.

### Counselling & appointment reminders

The same reminder approach as call-backs is also required for:

- **Counselling reminder** function
- **Appointment reminder** function

(including notifications at the scheduled time).

---

## 1.5 Counselling bookings

**What it does:** Reduces duplicate data entry when counselling is completed and shows booking details where staff work on the enquiry.

**Current issue**

When a counselling session is booked, appointment status shows as **“Scheduled”**. After the session, staff must:

1. Update the outcome to **“Counselling Done”** in the Enquiry module, and  
2. Manually open the Appointment module and change status from **“Scheduled”** to **“Completed”**.

**Requirements**

- Whenever the user selects outcome **“Counselling Done”** in the **Enquiry** module, the system should **automatically** update the related appointment status to **“Completed”**.
- Once counselling is booked through the calendar form in any stage—**Enquiry**, **Post Enquiry Follow-up**, **Counselling**, or **Post Counselling Follow-up**—the system should automatically display **booking date**, **time**, and **appointment status** next to the calendar button.
- Provide a **quick view** control to popup enquiry details (see [§1.6 Quick View](#16-quick-view)).

Calendar sync with Outlook/Google for counsellors is described in [Part 2 — Seamless calendar sync](#24-seamless-calendar-sync).

---

## 1.6 Quick View

**What it does:** Lets staff open enquiry and stage details from the list without many clicks through separate screens.

**Requirements**

- Replace the current **Action** column with a **three-dots** quick actions menu.
- On click, show options including:
  - **Edit**
  - **Delete**
  - **View ENQ**
  - **View PEFU**
  - **View CONS**
  - **View PCFU**

**Quick View popup content**

| Stage | Popup shows | Extra actions |
|-------|-------------|---------------|
| **ENQ** | Enquiry basic info | — |
| **Post Enquiry Follow Up (PEFU)** | Post Enquiry Follow Up information | **History** button; **Add New Follow Up** |
| **Counselling (CONS)** | Counselling information | **History** button |
| **Post Counselling Follow up (PCFU)** | Post Counselling Follow up information | **History** button; **Add New Follow Up** |

At present, users need multiple clicks to check follow-up dates, counselling dates, and other stage-related details. Quick View addresses that.

---

## 1.7 Personalised employee dashboard (staff)

**What it does:** Gives each staff member a single place to see workload, priorities, and today’s tasks.

### Top summary cards

| Card | Purpose |
|------|---------|
| Total Assigned Enquiries | Total active leads assigned to the employee |
| Counselling Booked | Upcoming counselling sessions |
| Pending Enrolments | Students near conversion |
| Converted Students | Successful enrolments |
| Conversion Rate | Performance percentage |

### Today’s priority section

Examples of priority items:

- Overdue follow-ups (count)
- Follow-ups due today (count)
- New leads assigned today (count)
- Appointment bookings (count)

### Tables on the dashboard

- **Personalised booked appointment** table
- **All callback reminder** table (today’s and future dates)
- **General enquiry** table (layout as per design mock-up)

---

## 1.8 Notification center

**What it does:** Ensures employees do not miss follow-ups, call-backs, new leads, sessions, or escalations.

**Employees should never miss follow-ups.**

Notifications should include:

| Type | Example message |
|------|-----------------|
| **A. Follow-up reminder** | “Follow-up with Sarah due in 15 mins.” |
| **B. Call back reminder** | “Student requested call back at 4:00 PM.” |
| **C. New lead assigned** | “You have been assigned a new enquiry.” |
| **D. Counselling / appointment reminder** | “Counselling session starts in 30 mins.” |
| **E. Escalation warning** | “This lead has not been contacted for 48 hrs.” |

---

## 1.9 Lead distribution (supervisor / admin)

**What it does:** Lets supervisors assign or reassign leads fairly, with visibility of each employee’s workload. Supports manual, automatic, or hybrid distribution.

### Assign Lead (quick action)

Add **Assign Lead** under the **Quick Actions** column:

**Quick Actions → Assign Lead → Assignment pop-up**

The pop-up should contain:

- An **Employee** dropdown list
- A **workload summary** for all employees to help choose the best assignee

**Workload summary example**

| Employee | Active leads | Pending follow-ups | Overdue follow-ups |
|----------|--------------|--------------------|--------------------|
| Staff A | 120 | 15 | 2 |
| Staff B | 85 | 10 | 1 |
| Staff C | 60 | 8 | 0 |

After selecting an employee and clicking **Assign**:

- The lead should **immediately** appear on that employee’s dashboard and lead list.

**Reassignment**

- Admin can **reassign** a lead at any time.
- When reassigned:
  - Remove the lead from the **previous** assignee’s dashboard and lead list.
  - Add the lead under the **new** assignee’s dashboard and lead list.
  - Keep **assignment history** (who had the lead previously and when reassignment occurred).

This supports fair workload distribution and visibility when assigning or reassigning leads.

### Distribution options

**Option A — Manual distribution (supervisor controlled)**

Supervisor manually assigns enquiries to staff.

Supervisor can:

- Select staff
- **Bulk assign** enquiries
- **Reassign** leads
- View **workload balance**
- See **conversion performance**

**Option B — Automatic distribution**

CRM automatically spreads enquiries (e.g. new enquiry goes to the staff member with the fewest active leads).

**Auto distribution rules (examples):**

- Round robin
- Least pending leads
- Course-based allocation (e.g. Aged Care leads → healthcare counsellor only)
- Campus-based allocation
- Staff availability
- Shift timing

**Option C — Hybrid system (recommended)**

Supervisor can:

- Turn **auto allocation** ON/OFF
- **Override** assignment manually
- **Redistribute** anytime

> **See also:** [Automatic lead router](#22-automatic-lead-router-smart-auto-assign) in Part 2 for the client-friendly summary of auto-assign benefits.

---

## 1.10 Admin & supervisor dashboard

**What it does:** Gives supervisors and admins performance and workload visibility across the team.

### Employee performance table

| Employee | Leads | Follow ups | Counselling | Enrolments | Conversion |
|----------|-------|------------|-------------|------------|------------|
| Sarah | 120 | 95 | 40 | 15 | 12% |
| David | 110 | 88 | 35 | 18 | 16% |

- Add a **first column** for **colour code** performance indicator:
  - Good
  - Average
  - Needs attention

**Filters:**

- Date range
- Employee name

### Workload distribution panel

| Employee | Active leads |
|----------|--------------|
| Sarah | 120 |
| David | 60 |
| Mark | 45 |

Supervisors use this to understand team workload at a glance.

> **See also:** [Clean performance & analytics charts](#22-clean-performance--analytics-charts) in Part 2 for dashboard visualisations.

---

## 1.11 Appointment module

**What it does:** Improves slot blocking, booking labels, online sessions, list behaviour, and who can change or delete records.

### Block slot

In **Block Slot**, support blocking by:

| Option | Behaviour |
|--------|-----------|
| **Today** | Block for today |
| **Tomorrow** | Block for tomorrow |
| **Ongoing** | Permanent block for the mentioned time slot |
| **Date range** | Block across a date range |
| **Specific date** | Block a single date |

Update the **date / date range** column to match the selected option.

**Access**

- **Staff** must **not** alter or delete **other staff members’** blocked slots.
- **Admin** can alter or delete any staff member’s blocked slots.

### Booking comments vs internal notes

- **Booking comment** — shown to students. Label in brackets:  
  *(Visible to the appointment recipient in confirmation emails — please do not include internal staff notes.)*
- **Internal staff notes** — label in brackets:  
  *(Internal staff notes – not visible to the appointment recipient in email confirmations.)*  
  This section must **not** appear in emails sent to students (remove from student-facing confirmation emails).

### Fields & integrations

- Remove fields that are **no longer required** (per design review).
- Integrate **Zoom API** for **online appointment** booking.

### Confirmation emails

- Replace title with: **Enable confirmation emails**
- Helper text (replacing prior yellow-highlighted note):  
  *(If unchecked, the appointment recipient will not receive a confirmation email.)*
- **Staff** access: cannot enable/disable this setting.
- **Admin** can enable or disable confirmation emails.

### Appointment list view

- **Quick actions:** first option **View**, second option **Delete** — **Delete** only for **Admin**, not staff.
- **New appointments** should appear at the **top** of the list (not the bottom).
- Add **Status** filter.
- Add **“Select specific date”** in the date range dropdown.
- **Search** by: student name, contact number, email.

---

## 1.12 CRM login & security

**What it does:** Improves account recovery and audit visibility for staff logins.

**Requirements**

- **Password reset** function for both **Admin** and **Student** logins.
- **Staff login history** table (who logged in and when), as per design mock-up.

---

# Part 2 — Platform upgrades (simplified)

This section uses plain language so you can share it with clients and staff. It describes broader CRM upgrades that complement Part 1. Where Part 1 already defines detailed rules (e.g. lead assignment, escalation hours), Part 1 takes precedence for implementation.

---

## 2.1 Visual enhancements

*Making the system easier to use and faster to navigate.*

### 2.1.1 Drag-and-drop student pipeline (Kanban board)

- **What it is:** A clean board with columns for each stage of a student’s journey (e.g. *New Enquiry → Contacted → Interviewing → Enrolling → Enrolled*). Each student is a card staff can drag into the next column.
- **Why it helps the business:** Team leaders see how many applications sit at each stage without scrolling through long spreadsheets.
- **Why staff love it:** Updating status is visual and quick—no deep menu navigation.

### 2.1.2 Clean performance & analytics charts

- **What it is:** Colour-coded charts on the dashboard showing real-time statistics instead of manual spreadsheets.
- **Why it helps the business:** Answers questions such as: which courses are most popular this month, where leads come from (Facebook, referrals, search), and which staff enrol the most students.
- **Why staff love it:** Insight without generating manual reports.

*Relates to:* [Admin & supervisor dashboard — performance table](#110-admin--supervisor-dashboard).

### 2.1.3 Swift search & quick-action bar (`Ctrl + K`)

- **What it is:** A search bar opened with a keyboard shortcut. Type a student’s name, email, or ID to jump to their record.
- **Why it helps the business:** Faster daily operations—fewer clicks to find a phone number or file.
- **Why staff love it:** Less time lost navigating menus.

*Relates to:* appointment list search by name, contact, and email in [§1.11](#111-appointment-module).

---

## 2.2 Smart backend & automation

*Letting the system handle repetitive work.*

### 2.2.1 Automatic lead router (smart auto-assign)

- **What it is:** New website enquiries are automatically assigned to the best available staff member.
- **Why it helps the business:** Leads are handled quickly instead of sitting unassigned; faster contact improves enrolment chances.
- **Why staff love it:** Fair distribution without waiting for manual assignment.

*Full rules (round robin, course/campus, hybrid, etc.):* [§1.9 Lead distribution](#19-lead-distribution-supervisor--admin).

### 2.2.2 Auto-SMS reminders & updates

- **What it is:** Text messaging built into the CRM.
- **Why it helps the business:** Automated appointment reminders (e.g. “Hi Alex, we have you booked for counselling tomorrow at 2 PM”) reduce no-shows.
- **Why staff love it:** Send texts from the CRM and see replies in the student’s chat log.

*Relates to:* [Callback](#13-callback-reminder), [counselling/appointment reminders](#14-escalation-counselling--appointment-reminders), and [notification center](#18-notification-center).

### 2.2.3 Alert & safety net alarm

- **What it is:** Monitors enquiries and flags leads that need attention.
- **Why it helps the business:** Reduces the risk of forgotten leads during busy intakes.
- **Why staff love it:** A safety net when workload is high.

*Enquiry escalation timings (24h yellow, 48h red, 72h supervisor):* [§1.4 Escalation](#14-escalation-counselling--appointment-reminders).

### 2.2.4 Real-time government USI verification

- **What it is:** One-click check of a student’s Unique Student Identifier (USI) against the Australian Government database.
- **Why it helps the business:** Meets legal USI verification requirements; confirms name, date of birth, and number quickly.
- **Why staff love it:** No separate government portal and copy-paste for each student.

### 2.2.5 Easy online invoicing & card payments

- **What it is:** Secure card payment links (Stripe) on invoices sent to students.
- **Why it helps the business:** Students pay from their phone; paid invoices mark themselves **Paid** and send a receipt automatically.
- **Why staff love it:** Less manual matching of bank transfers to invoices.

---

## 2.3 Student experience

*Making enrolment and compliance easier for students.*

### 2.3.1 Conversational stepper & document scanner

- **What it is:** A step-by-step enrolment flow instead of one long form. Students can upload a passport photo and the system can pre-fill name and date of birth.
- **Why it helps the business:** Shorter perceived forms mean more completed applications.
- **Why students love it:** Quick and mobile-friendly.

### 2.3.2 Hand-drawn in-browser signatures

- **What it is:** Students sign on phone or tablet for cancellations, extensions, and similar requests.
- **Why it helps the business:** Legally tracked authorisations saved as PDF receipts.
- **Why students love it:** No print, scan, or email cycle.

### 2.3.3 Student portal English & core skills testing

- **What it is:** Built-in online quiz in the student portal for English and basic literacy before admission.
- **Why it helps the business:** Supports ASQA compliance with a secure test record on the student file.
- **Why students love it:** One link in their portal to complete testing.

### 2.3.4 Seamless calendar sync

- **What it is:** CRM appointments sync to counsellors’ **Outlook** or **Google** calendars on their devices.
- **Why it helps the business:** Fewer double-bookings; personal calendar busy times can block CRM slots.
- **Why staff love it:** Manage college schedule from the phone calendar app.

*Relates to:* in-CRM booking display beside the calendar button in [§1.5](#15-counselling-bookings) and appointment module in [§1.11](#111-appointment-module).

---

# Feature cross-reference

| Topic | Detailed requirements | Plain-language summary |
|-------|----------------------|-------------------------|
| Lead assignment | [§1.9](#19-lead-distribution-supervisor--admin) | [§2.2.1](#221-automatic-lead-router-smart-auto-assign) |
| Follow-up escalation | [§1.4](#14-escalation-counselling--appointment-reminders) (24/48/72h) | [§2.2.3](#223-alert--safety-net-alarm) |
| Reminders (callback, counselling, appointment) | [§1.3](#13-callback-reminder), [§1.4](#14-escalation-counselling--appointment-reminders), [§1.8](#18-notification-center) | [§2.2.2](#222-auto-sms-reminders--updates) |
| Dashboards & analytics | [§1.7](#17-personalised-employee-dashboard-staff), [§1.10](#110-admin--supervisor-dashboard) | [§2.1.2](#212-clean-performance--analytics-charts) |
| Appointments & counselling | [§1.5](#15-counselling-bookings), [§1.11](#111-appointment-module) | [§2.3.4](#234-seamless-calendar-sync) |
| Quick access to records | [§1.6](#16-quick-view) | [§2.1.3](#213-swift-search--quick-action-bar-ctrl--k) |

---

*Sources: Enquiry Module Ph31052026 (PDF), Simplified Features (DOCX). Merged for Auztraining CRM.*
