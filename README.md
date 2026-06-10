# 💊 PharmaFEFO – Smart Pharmacy Stock Management System

PharmaFEFO is a full-stack web application designed to manage pharmaceutical stock in pharmacies and clinics while strictly enforcing the **FEFO rule (First Expired, First Out)**.

It helps reduce medication waste, prevent risks from expired drugs, and improve stock visibility.

---

# 🚨 Problem Statement

Pharmacies handle thousands of medication batches with expiration constraints:

- ❌ Expired medicines cause financial losses
- ❌ Risk of patient safety due to outdated drugs
- ❌ Lack of visibility on stock expiration
- ❌ Poor anticipation of shortages and overstock

---

# 💡 Solution

PharmaFEFO solves these issues by:

- 📦 Tracking all medication batches with expiration dates
- ⚠️ Highlighting expiry risks using color codes
- 🔄 Automatically applying FEFO rule for stock dispatch
- 📊 Providing alerts for upcoming expirations
- 💰 Generating financial loss reports due to expired stock

---

# 🎯 Key Features

## 📥 Stock Reception
- Add new medication batches
- Store batch number, quantity, and expiration date (DLU)
- Validate that expiration date is not in the past

---

## ⚠️ Expiration Monitoring
- Color-coded system:
  - 🟢 Green: > 6 months remaining
  - 🟠 Orange: < 90 days remaining
  - 🔴 Red: < 30 days remaining
- Filter critical alerts easily

---

## 🔄 FEFO Stock Dispatch (Core Feature)
- Automatically selects the batch with the nearest expiration date
- Ensures compliance with FEFO rule
- Prevents manual selection errors

---

## 🚨 Alerts System
- Notifications for:
  - Products expiring in 30 days
  - Products expiring in 90 days
- Dashboard warnings for critical stock

---

## 📊 Admin Reports
- Monthly financial loss reports
- Value of expired stock
- Data ready for chart visualization

---

# 🏗️ Architecture (MVC)
pharmafefo/
├── config/
│ └── database.php
├── public/
│ ├── index.php
│ └── css/
├── src/
│ ├── Controller/
│ ├── Entity/
│ ├── Repository/
│ ├── Service/
│ └── Enum/
├── templates/
│ ├── dashboard/
│ ├── stock/
│ ├── alerts/
│ └── layout/

---

# 👤 User Roles (RBAC System)

## 👨‍⚕️ Préparateur (Stock Manager)
- Add stock batches
- Register stock output (sales / dispensing)

## 🧑‍⚕️ Pharmacien (Supervisor)
- Validate inventory
- Manage expired or returned products
- Configure alert thresholds

## 👨‍💻 Admin (System Manager)
- Manage users
- View reports
- Access full system analytics

---

# ⚙️ Technologies Used

## Frontend
- HTML5
- CSS3
- JavaScript (Vanilla)

## Backend
- PHP 8+
- MVC Architecture
- PDO (MySQL)
- OOP Principles

## Database
- MySQL

---

# 🧠 Business Logic (FEFO Rule)

The system always prioritizes stock based on expiration:

### Example:

| Batch | Expiration Date | Priority |
|------|----------------|----------|
| A    | 2026-06-01     | HIGH     |
| B    | 2026-12-01     | LOW      |

👉 Batch A is always used first.

---

# 📊 Alert System Logic

| Status   | Condition              | Color  |
|----------|----------------------|--------|
| 🟢 Green  | > 6 months remaining | Safe   |
| 🟠 Orange | < 90 days remaining  | Warning|
| 🔴 Red    | < 30 days remaining  | Critical|

---

# 🔐 Security System

- Session-based authentication
- Role-Based Access Control (RBAC)
- Middleware protection for routes
- Strict MVC separation (SoC)

---

# 📦 Core Modules

- 🔐 Authentication System
- 📦 Stock Management
- 🔄 FEFO Engine
- ⚠️ Alert System
- 📊 Reporting System
- 👤 User Management

---

# 📈 Project Goals

- Reduce medication waste
- Improve pharmacy efficiency
- Ensure patient safety
- Optimize stock rotation
- Prevent financial losses

---

# 🚀 Installation & Setup

## 1. Clone Project
```bash
git clone https://github.com/ayoubsofi21/PharmaFEFO.git