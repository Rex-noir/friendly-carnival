import { filterConfig } from "@/Pages/Components/RoleFilter.vue";
import { UserRoles, UserStatus } from "@/types/enums.types";
import { Pagination } from "@/types/page.types";
import axios from "axios";

export default class UserUtils {
    /**
     *
     * @param value The search term (string | number)
     * @returns A promise that resolves to an AxiosResponse object containing the result
     */
    static async searchUser(value: string | number): Promise<User[]> {
        try {
            const response = await axios.post(route("users.search"), {
                value,
            });
            return response.data;
        } catch (error) {
            throw error;
        }
    }
    /**
     * Fetches a paginated list of users from the specified URL or default route,
     * with an optional filter configuration.
     * @param url Optional. The URL to fetch data from. If not provided, defaults to the route "users.index".
     * @param filterConfig Optional. An object containing filter configuration.
     * @returns A promise that resolves to a Pagination object containing an array of User objects.
     * @throws Throws an error if the HTTP request fails or returns a non-200 status code.
     */
    static async fetchUsers(
        url?: string,
        filterConfig?: filterConfig,
    ): Promise<Pagination<User[]>> {
        try {
            const params: Record<string, any> = {};
            if (filterConfig) {
                params.role = filterConfig.role;
                params.status = filterConfig.status;
            }
            const response = await axios.get(url || route("users.index"), {
                params,
            });
            return response.data;
        } catch (error) {
            throw error;
        }
    }

    /**
     * Update user information asynchronously.
     * @param info An object containing the user ID and updated email.
     * @returns A Promise resolving to the updated User object.
     * @throws Error if the update request fails or returns a non-200 status.
     */
    static async update(info: { id: number; email: string }): Promise<User> {
        try {
            const response = await axios.put(
                route("users.update", { id: info.id }),
                info,
            );
            return response.data;
        } catch (error) {
            throw error;
        }
    }
    /**
     * Deletes a user from the server.
     *
     * @param {number} id - The ID of the user to delete.
     * @returns {Promise<void>} A promise that resolves when the user is deleted, or rejects with an error.
     *
     * @throws {Error} - Re-throws any errors encountered during the deletion process.
     */
    static async delete(id: number): Promise<void> {
        try {
            await axios.delete(route("users.delete", { id: id }));
        } catch (error) {
            throw error;
        }
    }

    /**
     * Bans a user by their ID.
     *
     * This method sends a POST request to the server to ban a user identified by the provided ID.
     *
     * @param {number} id - The ID of the user to ban.
     * @returns {Promise<void>} A promise that resolves when the user has been successfully banned.
     * @throws Will throw an error if the request fails.
     */
    static async ban(id: number): Promise<void> {
        try {
            await axios.post(route("users.ban", { id: id }));
        } catch (error) {
            throw error;
        }
    }
}
