// types.ts
interface Location {
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

interface Software {
    os: string;
    distro: string;
    kernel: string;
    arc: string;
    webserver: string;
    php: string;
}

interface Disk {
    total: number;
    free: number;
    human_total: string;
    human_free: string;
}

interface Ram {
    total: number;
    free: number;
    human_total: string;
    human_free: string;
}

interface Swap {
    total: number;
    free: number;
    human_total: string;
    human_free: string;
}

interface Hardware {
    cpu: string;
    cpu_count: number;
    model: string;
    virtualization: string;
    disk: Disk;
    ram: Ram;
    swap: Swap;
}

interface Uptime {
    uptime: string;
    booted_at: string;
}

interface Server {
    software: Software;
    hardware: Hardware;
    uptime: Uptime;
}

interface Database {
    driver: string;
    version: string;
}

export interface SystemInfo {
    host: Location;
    client: Location;
    server: Server;
    database: Database;
}

export interface RealTimeSystemInfo {
    cpu_load: {
        "1m": number; // Example: "31.79%"
        "5m": number; // Example: "28.47%"
        "15m": number; // Example: "20.95%"
    };
    memory_usage: {
        memory_total: string; // Example: "3920 MB"
        memory_used: string; // Example: "3538 MB"
        memory_usage: string; // Example: "90.26 %"
    };
    storage_usage: {
        disk_total: string; // Example: "1031018.43 MB"
        disk_used: string; // Example: "55333.4 MB"
        disk_free: string; // Example: "975685.02 MB"
    };
    uptime: string;
    database: string;
}
