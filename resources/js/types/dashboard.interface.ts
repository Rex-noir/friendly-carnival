// types.ts
export interface Location {
    ip: string;
    ip_private: string;
    hostname: string;
    region: string;
    city: string;
    country: string;
    location: string;
    timezone: string;
    org: string;
    phone: string;
    postal: string;
}

export interface Software {
    os: string;
    distro: string;
    kernel: string;
    arc: string;
    webserver: string;
    php: string;
}

export interface Disk {
    total: number;
    free: number;
    human_total: string;
    human_free: string;
}

export interface Ram {
    total: number;
    free: number;
    human_total: string;
    human_free: string;
}

export interface Swap {
    total: number;
    free: number;
    human_total: string;
    human_free: string;
}

export interface Hardware {
    cpu: string;
    cpu_count: number;
    model: string;
    virtualization: string;
    disk: Disk;
    ram: Ram;
    swap: Swap;
}

export interface Uptime {
    uptime: string;
    booted_at: string;
}

export interface Server {
    software: Software;
    hardware: Hardware;
    uptime: Uptime;
}

export interface Database {
    driver: string;
    version: string;
}

export interface SystemInfo {
    host: Location;
    client: Location;
    server: Server;
    database: Database;
}
