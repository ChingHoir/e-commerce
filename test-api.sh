#!/bin/bash

# Passport & RBAC API Testing Script
# This script tests all authentication and authorization endpoints

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# API Base URL
BASE_URL="http://localhost:8000/api"

# Test counters
TESTS_PASSED=0
TESTS_FAILED=0

# Helper function to print test results
print_result() {
    local test_name=$1
    local expected_code=$2
    local actual_code=$3
    
    if [ "$expected_code" -eq "$actual_code" ]; then
        echo -e "${GREEN}✓ PASS${NC}: $test_name (HTTP $actual_code)"
        ((TESTS_PASSED++))
    else
        echo -e "${RED}✗ FAIL${NC}: $test_name (Expected $expected_code, got $actual_code)"
        ((TESTS_FAILED++))
    fi
}

# Separator
print_separator() {
    echo -e "${BLUE}========================================${NC}"
    echo "$1"
    echo -e "${BLUE}========================================${NC}"
}

# Test function with detailed output
test_endpoint() {
    local method=$1
    local endpoint=$2
    local data=$3
    local token=$4
    local expected_code=$5
    local test_name=$6
    
    if [ -z "$token" ]; then
        response=$(curl -s -w "\n%{http_code}" -X $method "$BASE_URL$endpoint" \
            -H "Content-Type: application/json" \
            -d "$data")
    else
        response=$(curl -s -w "\n%{http_code}" -X $method "$BASE_URL$endpoint" \
            -H "Authorization: Bearer $token" \
            -H "Content-Type: application/json" \
            -d "$data")
    fi
    
    http_code=$(echo "$response" | tail -n1)
    body=$(echo "$response" | sed '$d')
    
    print_result "$test_name" "$expected_code" "$http_code"
    
    if [ "$expected_code" -ne "$http_code" ]; then
        echo "Response: $body"
    fi
}

# ============================================
# AUTHENTICATION TESTS
# ============================================
print_separator "Testing Authentication Endpoints"

# Test 1: Invalid Login (Should Fail)
echo -e "${YELLOW}Test 1: Invalid Credentials${NC}"
test_endpoint "POST" "/auth/login" \
    '{"email":"invalid@example.com","password":"wrong"}' \
    "" \
    "401" \
    "Login with invalid credentials"

# Test 2: Admin Login
echo -e "${YELLOW}Test 2: Admin Login${NC}"
admin_response=$(curl -s -X POST "$BASE_URL/auth/login" \
    -H "Content-Type: application/json" \
    -d '{"email":"admin@example.com","password":"password"}')

admin_token=$(echo $admin_response | grep -o '"token":"[^"]*' | cut -d'"' -f4)

if [ -z "$admin_token" ]; then
    echo -e "${RED}✗ FAIL${NC}: Admin login - Could not extract token"
    ((TESTS_FAILED++))
else
    echo -e "${GREEN}✓ PASS${NC}: Admin login successful"
    echo "Token: ${admin_token:0:20}..."
    ((TESTS_PASSED++))
fi

# Test 3: Manager Login
echo -e "${YELLOW}Test 3: Manager Login${NC}"
manager_response=$(curl -s -X POST "$BASE_URL/auth/login" \
    -H "Content-Type: application/json" \
    -d '{"email":"manager@example.com","password":"password"}')

manager_token=$(echo $manager_response | grep -o '"token":"[^"]*' | cut -d'"' -f4)

if [ -z "$manager_token" ]; then
    echo -e "${RED}✗ FAIL${NC}: Manager login - Could not extract token"
    ((TESTS_FAILED++))
else
    echo -e "${GREEN}✓ PASS${NC}: Manager login successful"
    echo "Token: ${manager_token:0:20}..."
    ((TESTS_PASSED++))
fi

# Test 4: Staff Login
echo -e "${YELLOW}Test 4: Staff Login${NC}"
staff_response=$(curl -s -X POST "$BASE_URL/auth/login" \
    -H "Content-Type: application/json" \
    -d '{"email":"staff@example.com","password":"password"}')

staff_token=$(echo $staff_response | grep -o '"token":"[^"]*' | cut -d'"' -f4)

if [ -z "$staff_token" ]; then
    echo -e "${RED}✗ FAIL${NC}: Staff login - Could not extract token"
    ((TESTS_FAILED++))
else
    echo -e "${GREEN}✓ PASS${NC}: Staff login successful"
    echo "Token: ${staff_token:0:20}..."
    ((TESTS_PASSED++))
fi

# ============================================
# AUTHORIZED ENDPOINT TESTS
# ============================================
print_separator "Testing Authorized Endpoints"

# Test 5: Get Current User (Admin)
echo -e "${YELLOW}Test 5: Get Current User (Admin)${NC}"
test_endpoint "GET" "/auth/me" "" "$admin_token" "200" "Admin get current user"

# Test 6: Get Current User (Manager)
echo -e "${YELLOW}Test 6: Get Current User (Manager)${NC}"
test_endpoint "GET" "/auth/me" "" "$manager_token" "200" "Manager get current user"

# Test 7: Get Current User (Staff)
echo -e "${YELLOW}Test 7: Get Current User (Staff)${NC}"
test_endpoint "GET" "/auth/me" "" "$staff_token" "200" "Staff get current user"

# Test 8: Get Tokens (Admin)
echo -e "${YELLOW}Test 8: Get All Tokens${NC}"
test_endpoint "GET" "/auth/tokens" "" "$admin_token" "200" "Admin list all tokens"

# ============================================
# PRODUCT CRUD AUTHORIZATION TESTS
# ============================================
print_separator "Testing Product Authorization (RBAC)"

# Test 9: Admin Create Product
echo -e "${YELLOW}Test 9: Admin Create Product${NC}"
test_endpoint "POST" "/products" \
    '{"name":"Admin Product","category_id":1,"pricing":99.99,"description":"Test"}' \
    "$admin_token" \
    "201" \
    "Admin create product"

# Test 10: Manager Create Product
echo -e "${YELLOW}Test 10: Manager Create Product${NC}"
test_endpoint "POST" "/products" \
    '{"name":"Manager Product","category_id":1,"pricing":149.99,"description":"Test"}' \
    "$manager_token" \
    "201" \
    "Manager create product"

# Test 11: Staff Create Product (Should Fail)
echo -e "${YELLOW}Test 11: Staff Create Product (Should Fail)${NC}"
test_endpoint "POST" "/products" \
    '{"name":"Staff Product","category_id":1,"pricing":199.99,"description":"Test"}' \
    "$staff_token" \
    "403" \
    "Staff attempt create product (403)"

# ============================================
# CATEGORY AUTHORIZATION TESTS
# ============================================
print_separator "Testing Category Authorization"

# Test 12: Admin Create Category
echo -e "${YELLOW}Test 12: Admin Create Category${NC}"
test_endpoint "POST" "/categories" \
    '{"name":"Admin Category"}' \
    "$admin_token" \
    "201" \
    "Admin create category"

# Test 13: Manager Create Category
echo -e "${YELLOW}Test 13: Manager Create Category${NC}"
test_endpoint "POST" "/categories" \
    '{"name":"Manager Category"}' \
    "$manager_token" \
    "201" \
    "Manager create category"

# Test 14: Staff Create Category (Should Fail)
echo -e "${YELLOW}Test 14: Staff Create Category (Should Fail)${NC}"
test_endpoint "POST" "/categories" \
    '{"name":"Staff Category"}' \
    "$staff_token" \
    "403" \
    "Staff attempt create category (403)"

# ============================================
# UNAUTHENTICATED REQUESTS TESTS
# ============================================
print_separator "Testing Unauthenticated Requests"

# Test 15: No Token - Create Product
echo -e "${YELLOW}Test 15: Create Product Without Token${NC}"
test_endpoint "POST" "/products" \
    '{"name":"NoAuth Product","category_id":1,"pricing":99.99}' \
    "" \
    "401" \
    "Create product without authentication"

# Test 16: No Token - Get Current User
echo -e "${YELLOW}Test 16: Get Current User Without Token${NC}"
test_endpoint "GET" "/auth/me" "" "" "401" "Get current user without authentication"

# ============================================
# LOGOUT TESTS
# ============================================
print_separator "Testing Logout"

# Test 17: Logout (Admin)
echo -e "${YELLOW}Test 17: Admin Logout${NC}"
test_endpoint "POST" "/auth/logout" "" "$admin_token" "200" "Admin logout"

# ============================================
# FINAL SUMMARY
# ============================================
print_separator "Test Summary"

echo -e "${GREEN}Tests Passed: $TESTS_PASSED${NC}"
echo -e "${RED}Tests Failed: $TESTS_FAILED${NC}"

total=$((TESTS_PASSED + TESTS_FAILED))
echo "Total: $total tests"

if [ $TESTS_FAILED -eq 0 ]; then
    echo -e "${GREEN}All tests passed!${NC}"
    exit 0
else
    echo -e "${RED}Some tests failed. Please review the output above.${NC}"
    exit 1
fi
