-- Procurement Module Tables
USE eras_app;

CREATE TABLE IF NOT EXISTS approval_levels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entity VARCHAR(100) NOT NULL,
    level INT NOT NULL,
    role_id INT NOT NULL,
    min_value DECIMAL(15,2) DEFAULT 0.00,
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS requisitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    requested_by INT NOT NULL,
    description TEXT,
    total_estimated_cost DECIMAL(15,2) DEFAULT 0.00,
    status VARCHAR(50) DEFAULT 'draft',
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id),
    FOREIGN KEY (requested_by) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS requisition_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requisition_id INT NOT NULL,
    item_description VARCHAR(255) NOT NULL,
    quantity DECIMAL(15,2) NOT NULL,
    estimated_unit_price DECIMAL(15,2) NOT NULL,
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (requisition_id) REFERENCES requisitions(id)
);

CREATE TABLE IF NOT EXISTS procurements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requisition_id INT NOT NULL,
    procurement_method VARCHAR(50) NOT NULL, -- direct, rfq, tender
    assigned_to INT,
    status VARCHAR(50) DEFAULT 'open',
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (requisition_id) REFERENCES requisitions(id),
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS tenders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    procurement_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    closing_date DATETIME,
    status VARCHAR(50) DEFAULT 'open',
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (procurement_id) REFERENCES procurements(id)
);

CREATE TABLE IF NOT EXISTS tender_bids (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tender_id INT NOT NULL,
    supplier_id INT NOT NULL,
    bid_amount DECIMAL(15,2) NOT NULL,
    technical_score DECIMAL(5,2) DEFAULT 0.00,
    financial_score DECIMAL(5,2) DEFAULT 0.00,
    total_score DECIMAL(5,2) DEFAULT 0.00,
    status VARCHAR(50) DEFAULT 'submitted',
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tender_id) REFERENCES tenders(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

CREATE TABLE IF NOT EXISTS evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tender_id INT NOT NULL,
    evaluator_id INT NOT NULL,
    supplier_id INT NOT NULL,
    technical_score DECIMAL(5,2) NOT NULL,
    financial_score DECIMAL(5,2) NOT NULL,
    comments TEXT,
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tender_id) REFERENCES tenders(id),
    FOREIGN KEY (evaluator_id) REFERENCES users(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

CREATE TABLE IF NOT EXISTS awards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tender_id INT NOT NULL,
    supplier_id INT NOT NULL,
    awarded_amount DECIMAL(15,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tender_id) REFERENCES tenders(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

CREATE TABLE IF NOT EXISTS contracts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    award_id INT NOT NULL,
    contract_number VARCHAR(100) UNIQUE NOT NULL,
    start_date DATE,
    end_date DATE,
    sla_terms TEXT,
    status VARCHAR(50) DEFAULT 'active',
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (award_id) REFERENCES awards(id)
);

CREATE TABLE IF NOT EXISTS goods_receipts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contract_id INT NOT NULL,
    received_by INT NOT NULL,
    received_date DATETIME NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (contract_id) REFERENCES contracts(id),
    FOREIGN KEY (received_by) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS goods_receipt_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    goods_receipt_id INT NOT NULL,
    description TEXT NOT NULL,
    quantity_received DECIMAL(15,2) NOT NULL,
    company_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (goods_receipt_id) REFERENCES goods_receipts(id)
);

-- Add award_id to bills to link procurement awards to payments
ALTER TABLE bills ADD COLUMN IF NOT EXISTS award_id INT;
